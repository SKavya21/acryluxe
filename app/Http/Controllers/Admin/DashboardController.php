<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $paidOrders = Order::query()->where('payment_status', 'paid');

        $stats = [
            'revenue' => (float) (clone $paidOrders)->sum('total'),
            'orders' => Order::query()->count(),
            'customers' => User::query()->where('is_admin', false)->count(),
            'products' => Product::query()->count(),
            'lowStock' => Product::query()->get()->filter(
                fn (Product $product): bool => $product->totalStock() >= 1 && $product->totalStock() <= 5,
            )->count(),
            'pendingOrders' => Order::query()->whereIn('status', ['pending', 'processing'])->count(),
        ];

        $recentOrders = Order::query()
            ->with('user')
            ->latest()
            ->limit(8)
            ->get();

        $topProducts = OrderItem::query()
            ->selectRaw('product_name, SUM(quantity) as units, SUM(line_total) as revenue')
            ->groupBy('product_name')
            ->orderByDesc('units')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentOrders', 'topProducts'));
    }
}
