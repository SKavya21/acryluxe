<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schema;

class CheckoutController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        if (! $request->user()) {
            return redirect()->route('login', [
                'backurl' => route('cart.index', absolute: false),
            ]);
        }

        $validated = $request->validate([
            'payment_method' => ['required', 'in:cod,stripe'],
        ]);

        $cart = $this->normalizedCart($request);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $productIds = collect($cart)->pluck('product_id')->unique()->all();
        $products = Product::whereIn('id', $productIds)->get()->keyBy('id');

        $subtotal = 0;
        foreach ($cart as $item) {
            $product = $products->get((int) $item['product_id']);

            if (! $product) {
                return redirect()->route('cart.index')->with('error', 'One or more cart items are no longer available.');
            }

            $quantity = (int) $item['quantity'];
            if ($quantity > 100) {
                return redirect()->route('cart.index')->with('error', "You can order up to 100 of {$product->name}.");
            }

            $available = (int) ($product->sizeInventory()[$item['size']] ?? 0);
            if ($quantity > $available) {
                return redirect()->route('cart.index')->with('error', "{$product->name} does not have enough stock in size {$item['size']}.");
            }

            $subtotal += $product->price * $quantity;
        }

        $shipping = $subtotal >= 599 ? 0 : 49;
        $total = $subtotal + $shipping;
        $orderNumber = 'ACR-' . now()->format('YmdHis') . '-' . random_int(1000, 9999);

        $order = DB::transaction(function () use ($cart, $products, $validated, $subtotal, $shipping, $total, $orderNumber, $request) {
            $order = Order::create([
                'user_id' => $request->user()?->id,
                'order_number' => $orderNumber,
                'status' => 'pending',
                'payment_status' => $validated['payment_method'] === 'cod' ? 'pending' : 'pending_payment',
                'payment_method' => $validated['payment_method'],
                'currency' => 'INR',
                'subtotal' => $subtotal,
                'shipping' => $shipping,
                'total' => $total,
            ]);

            foreach ($cart as $item) {
                $product = $products->get((int) $item['product_id']);
                $quantity = (int) $item['quantity'];
                $lineTotal = $product->price * $quantity;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'product_color' => $product->color,
                    'product_size' => $item['size'],
                    'unit_price' => $product->price,
                    'quantity' => $quantity,
                    'line_total' => $lineTotal,
                ]);
            }

            return $order;
        });

        if ($validated['payment_method'] === 'stripe') {
            $checkoutUrl = $this->createStripeCheckoutSession($order, $products->values()->all(), $cart);

            if ($checkoutUrl) {
                return redirect()->away($checkoutUrl);
            }

            return redirect()->route('cart.index')->with('error', 'Stripe checkout is not configured yet. Use cash on delivery or set STRIPE keys.');
        }

        try {
            $this->captureInventoryAndMarkPaid($order);
        } catch (\RuntimeException $exception) {
            return redirect()->route('cart.index')->with('error', $exception->getMessage());
        }

        $this->clearCart($request);

        return redirect()->route('cart.index')->with('success', 'Order placed successfully. Inventory has been updated.');
    }

    public function stripeSuccess(Request $request): RedirectResponse
    {
        $sessionId = $request->query('session_id');

        if (! $sessionId) {
            return redirect()->route('cart.index')->with('error', 'Missing payment session.');
        }

        $secret = config('services.stripe.secret');
        if (! $secret) {
            return redirect()->route('cart.index')->with('error', 'Stripe is not configured.');
        }

        $response = Http::asForm()
            ->withToken($secret)
            ->get('https://api.stripe.com/v1/checkout/sessions/' . $sessionId);

        if (! $response->successful()) {
            return redirect()->route('cart.index')->with('error', 'Unable to verify payment.');
        }

        $payload = $response->json();
        $order = Order::where('stripe_session_id', $sessionId)->first();

        if (! $order) {
            return redirect()->route('cart.index')->with('error', 'Order not found.');
        }

        if (($payload['payment_status'] ?? null) !== 'paid') {
            return redirect()->route('cart.index')->with('error', 'Payment is not completed yet.');
        }

        if ($order->payment_status !== 'paid') {
            try {
                $this->captureInventoryAndMarkPaid($order, $payload['payment_intent'] ?? null);
                $this->clearCart($request);
            } catch (\RuntimeException $exception) {
                return redirect()->route('cart.index')->with('error', $exception->getMessage());
            }
        }

        return redirect()->route('cart.index')->with('success', 'Payment confirmed and order completed.');
    }

    public function stripeCancel(Request $request): RedirectResponse
    {
        return redirect()->route('cart.index')->with('error', 'Payment was cancelled. Your cart is still available.');
    }

    private function captureInventoryAndMarkPaid(Order $order, ?string $paymentIntent = null): void
    {
        DB::transaction(function () use ($order, $paymentIntent) {
            $freshOrder = Order::query()->with('items')->lockForUpdate()->findOrFail($order->id);

            foreach ($freshOrder->items as $item) {
                $product = Product::query()->lockForUpdate()->find($item->product_id);

                $sizes = $product?->sizeInventory() ?? [];
                if (! $product || (int) ($sizes[$item->product_size] ?? 0) < $item->quantity) {
                    throw new \RuntimeException('Insufficient stock while finalizing the order.');
                }

                $sizes[$item->product_size] -= $item->quantity;
                $product->update(['sizes' => $sizes]);
            }

            $freshOrder->update([
                'payment_status' => 'paid',
                'status' => 'processing',
                'payment_provider_id' => $paymentIntent,
                'placed_at' => now(),
            ]);
        });
    }

    private function createStripeCheckoutSession(Order $order, array $products, array $cart): ?string
    {
        $secret = config('services.stripe.secret');

        if (! $secret) {
            return null;
        }

        $lineItems = [];
        foreach ($cart as $item) {
            $product = $products->get((int) $item['product_id']);
            $quantity = (int) $item['quantity'];
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'inr',
                    'product_data' => [
                        'name' => $product->name,
                        'description' => trim(collect([$product->color, 'Size ' . $item['size']])->filter()->implode(' | ')),
                    ],
                    'unit_amount' => (int) round($product->price * 100),
                ],
                'quantity' => $quantity,
            ];
        }

        $response = Http::asForm()
            ->withToken($secret)
            ->post('https://api.stripe.com/v1/checkout/sessions', [
                'mode' => 'payment',
                'success_url' => route('checkout.stripe.success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('checkout.stripe.cancel'),
                'metadata[order_id]' => $order->id,
                'client_reference_id' => $order->order_number,
                'line_items' => $lineItems,
                'shipping_address_collection[allowed_countries][0]' => 'IN',
            ]);

        if (! $response->successful()) {
            return null;
        }

        $session = $response->json();

        $order->update([
            'stripe_session_id' => $session['id'] ?? null,
        ]);

        return $session['url'] ?? null;
    }

    private function normalizedCart(Request $request): array
    {
        if ($request->user() && Schema::hasTable('cart_items')) {
            return CartItem::where('user_id', $request->user()->id)
                ->get()
                ->mapWithKeys(fn (CartItem $item) => [
                    $item->product_id . '|' . rawurlencode($item->size) => [
                        'product_id' => (int) $item->product_id,
                        'size' => $item->size,
                        'quantity' => (int) $item->quantity,
                        'added_at' => $item->created_at?->toDateTimeString(),
                    ],
                ])
                ->all();
        }

        return session()->get('cart', []);
    }

    private function clearCart(Request $request): void
    {
        if ($request->user() && Schema::hasTable('cart_items')) {
            CartItem::where('user_id', $request->user()->id)->delete();
            return;
        }

        session()->forget('cart');
    }
}
