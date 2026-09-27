<?php

namespace App\Providers;

use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            if (Auth::check() && Schema::hasTable('cart_items')) {
                $cartCount = (int) CartItem::where('user_id', Auth::id())->sum('quantity');
                $view->with('cartCount', $cartCount);
                return;
            }

            if (request()->hasSession()) {
                $cart = session('cart', []);
                $view->with('cartCount', collect($cart)->sum('quantity'));
                return;
            }

            $view->with('cartCount', 0);
        });
    }
}
