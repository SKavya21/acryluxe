<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(Request $request): View
    {
        $cart = $this->normalizedCart($request);
        $productIds = collect($cart)->pluck('product_id')->unique()->all();
        $products = Product::whereIn('id', $productIds)->get()->keyBy('id');

        $items = collect($cart)->map(function (array $item) use ($products) {
            $product = $products->get((int) $item['product_id']);
            $quantity = (int) $item['quantity'];
            $unitPrice = $product?->price ?? 0;

            return [
                'product' => $product,
                'size' => $item['size'],
                'quantity' => $quantity,
                'line_total' => $unitPrice * $quantity,
            ];
        })->filter(fn (array $item) => $item['product']);

        $subtotal = $items->sum('line_total');

        return view('cart.index', [
            'items' => $items,
            'subtotal' => $subtotal,
        ]);
    }

    public function add(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate(['size' => ['required', 'string']]);
        $size = $validated['size'];
        $available = (int) ($product->sizeInventory()[$size] ?? 0);

        if ($available < 1) {
            return back()->with('error', 'That size is out of stock.');
        }

        $currentQuantity = $this->getCurrentQuantity($request, $product->id, $size);
        $quantity = $currentQuantity + 1;

        if ($quantity > min(100, $available)) {
            return back()->with('error', "Only {$available} of size {$size} are available.");
        }

        if ($request->user() && Schema::hasTable('cart_items')) {
            CartItem::updateOrCreate(
                [
                    'user_id' => $request->user()->id,
                    'product_id' => $product->id,
                    'size' => $size,
                ],
                [
                    'quantity' => $quantity,
                ],
            );
        } else {
            $cart = session()->get('cart', []);
            $cart[$this->cartKey($product->id, $size)] = [
                'product_id' => $product->id,
                'size' => $size,
                'quantity' => $quantity,
                'added_at' => now()->toDateTimeString(),
            ];
            session()->put('cart', $cart);
        }

        return back()->with('success', 'Product added to cart.');
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1', 'max:100'],
            'size' => ['required', 'string'],
        ]);
        $size = $validated['size'];
        $available = (int) ($product->sizeInventory()[$size] ?? 0);
        if ($validated['quantity'] > $available) {
            return back()->with('error', "Only {$available} of size {$size} are available.");
        }

        if ($request->user() && Schema::hasTable('cart_items')) {
            $item = CartItem::where('user_id', $request->user()->id)
                ->where('product_id', $product->id)
                ->where('size', $size)
                ->first();

            if (! $item) {
                return back()->with('error', 'Product is not in the cart.');
            }

            $item->update(['quantity' => $validated['quantity']]);
        } else {
            $cart = session()->get('cart', []);

            $cartKey = $this->cartKey($product->id, $size);
            if (! array_key_exists($cartKey, $cart)) {
                return back()->with('error', 'Product is not in the cart.');
            }

            $cart[$cartKey]['quantity'] = $validated['quantity'];
            session()->put('cart', $cart);
        }

        return back()->with('success', 'Cart updated.');
    }

    public function remove(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate(['size' => ['required', 'string']]);
        $size = $validated['size'];

        if ($request->user() && Schema::hasTable('cart_items')) {
            CartItem::where('user_id', $request->user()->id)
                ->where('product_id', $product->id)
                ->where('size', $size)
                ->delete();
        } else {
            $cart = session()->get('cart', []);
            unset($cart[$this->cartKey($product->id, $size)]);
            session()->put('cart', $cart);
        }

        return back()->with('success', 'Product removed from cart.');
    }

    public function clear(Request $request): RedirectResponse
    {
        if ($request->user() && Schema::hasTable('cart_items')) {
            CartItem::where('user_id', $request->user()->id)->delete();
        } else {
            session()->forget('cart');
        }

        return redirect()->route('cart.index')->with('success', 'Cart cleared.');
    }

    private function getCurrentQuantity(Request $request, int $productId, string $size): int
    {
        if ($request->user() && Schema::hasTable('cart_items')) {
            return (int) CartItem::where('user_id', $request->user()->id)
                ->where('product_id', $productId)
                ->where('size', $size)
                ->value('quantity');
        }

            return (int) (session('cart', [])[$this->cartKey($productId, $size)]['quantity'] ?? 0);
    }

    private function normalizedCart(Request $request): array
    {
        if ($request->user() && Schema::hasTable('cart_items')) {
            return CartItem::where('user_id', $request->user()->id)
                ->get()
                ->mapWithKeys(fn (CartItem $item) => [
                    $this->cartKey($item->product_id, $item->size) => [
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

    private function cartKey(int $productId, ?string $size): string
    {
        return $productId . '|' . rawurlencode($size ?? '');
    }
}
