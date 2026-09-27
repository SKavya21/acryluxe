<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\CartItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(Request $request): View
    {
        return view('auth.login', [
            'backurl' => $this->cartBackUrl($request->query('backurl')),
        ]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $this->mergeSessionCartIntoDatabase($request);

        $request->session()->regenerate();

        return redirect($this->cartBackUrl($request->input('backurl')) ?? '/');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    private function mergeSessionCartIntoDatabase(Request $request): void
    {
        $user = $request->user();
        if (! $user || ! Schema::hasTable('cart_items')) {
            return;
        }

        $sessionCart = $request->session()->get('cart', []);
        if (empty($sessionCart)) {
            return;
        }

        foreach ($sessionCart as $productId => $item) {
            $quantity = max(1, (int) ($item['quantity'] ?? 1));
            $productId = (int) ($item['product_id'] ?? explode('|', (string) $productId, 2)[0]);
            $size = (string) ($item['size'] ?? '');
            if ($size === '') {
                continue;
            }

            $existing = CartItem::where('user_id', $user->id)
                ->where('product_id', $productId)
                ->where('size', $size)
                ->first();

            if ($existing) {
                $existing->update([
                    'quantity' => $existing->quantity + $quantity,
                ]);
            } else {
                CartItem::create([
                    'user_id' => $user->id,
                    'product_id' => $productId,
                    'size' => $size,
                    'quantity' => $quantity,
                ]);
            }
        }

        $request->session()->forget('cart');
    }

    private function cartBackUrl(mixed $backurl): ?string
    {
        return $backurl === route('cart.index', absolute: false)
            ? route('cart.index', absolute: false)
            : null;
    }
}
