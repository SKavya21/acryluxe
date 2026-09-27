@extends('admin.layout')

@section('title', 'Admin dashboard')
@section('section', 'Overview')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-end gap-3 mb-4">
    <div>
        <p class="admin-eyebrow">Acryluxe control room</p>
        <h1 class="admin-title">Good morning, {{ auth()->user()->name }}.</h1>
        <p class="admin-muted mb-0">Keep the storefront, customers, products, and orders moving from one place.</p>
    </div>
    <a class="admin-button" href="{{ route('admin.products.create') }}">Add product</a>
</div>

<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3"><div class="admin-panel stat-card"><div class="stat-label">Paid revenue</div><div class="stat-value">₹{{ number_format($stats['revenue'], 2) }}</div><div class="stat-note">All completed payments</div></div></div>
    <div class="col-sm-6 col-xl-3"><div class="admin-panel stat-card"><div class="stat-label">Orders</div><div class="stat-value">{{ number_format($stats['orders']) }}</div><div class="stat-note">{{ $stats['pendingOrders'] }} need attention</div></div></div>
    <div class="col-sm-6 col-xl-3"><div class="admin-panel stat-card"><div class="stat-label">Customers</div><div class="stat-value">{{ number_format($stats['customers']) }}</div><div class="stat-note">Registered shoppers</div></div></div>
    <div class="col-sm-6 col-xl-3"><div class="admin-panel stat-card"><div class="stat-label">Catalog</div><div class="stat-value">{{ number_format($stats['products']) }}</div><div class="stat-note">{{ $stats['lowStock'] }} low-stock items</div></div></div>
</div>

<div class="row g-4">
    <div class="col-xl-8">
        <section class="admin-panel">
            <div class="d-flex justify-content-between align-items-center p-3 border-bottom">
                <div><p class="admin-eyebrow mb-1">Latest activity</p><h2 class="h4 mb-0">Recent orders</h2></div>
                <a class="admin-button secondary" href="{{ route('admin.orders.index') }}">Manage orders</a>
            </div>
            <div class="table-responsive">
                <table class="table admin-table mb-0">
                    <thead><tr><th>Order</th><th>Customer</th><th>Status</th><th class="text-end">Total</th></tr></thead>
                    <tbody>
                    @forelse($recentOrders as $order)
                        <tr><td><strong>{{ $order->order_number }}</strong><div class="admin-muted small">{{ $order->created_at?->format('d M Y') }}</div></td><td>{{ $order->user?->name ?: 'Guest' }}</td><td><span class="status-pill">{{ $order->status }}</span></td><td class="text-end">₹{{ number_format($order->total, 2) }}</td></tr>
                    @empty
                        <tr><td colspan="4" class="text-center admin-muted py-5">No orders have been placed yet.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>
    <div class="col-xl-4">
        <section class="admin-panel p-3 h-100">
            <p class="admin-eyebrow mb-1">Merchandising</p><h2 class="h4 mb-3">Top products</h2>
            @forelse($topProducts as $product)
                <div class="d-flex justify-content-between gap-3 py-3 border-bottom"><div><strong>{{ $product->product_name }}</strong><div class="admin-muted small">{{ $product->units }} units sold</div></div><span>₹{{ number_format($product->revenue, 2) }}</span></div>
            @empty
                <p class="admin-muted">Sales data will appear here after the first order.</p>
            @endforelse
        </section>
    </div>
</div>
@endsection
