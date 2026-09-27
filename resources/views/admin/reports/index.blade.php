@extends('admin.layout')

@section('title', 'Sales reports')
@section('section', 'Reports')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-end gap-3 mb-4">
    <div><p class="admin-eyebrow">Performance</p><h1 class="admin-title">Sales reports</h1><p class="admin-muted mb-0">Review order volume, paid revenue, and units sold for any date range.</p></div>
    <a class="admin-button" href="{{ route('admin.reports.download', ['from' => $from, 'to' => $to]) }}">Download CSV</a>
</div>

<form class="admin-panel p-3 mb-4 row g-3 align-items-end" method="GET" action="{{ route('admin.reports.index') }}">
    <div class="col-md-4"><label class="form-label" for="from">From</label><input class="form-control" type="date" id="from" name="from" value="{{ $from }}"></div>
    <div class="col-md-4"><label class="form-label" for="to">To</label><input class="form-control" type="date" id="to" name="to" value="{{ $to }}"></div>
    <div class="col-md-4"><button class="admin-button" type="submit">Refresh report</button></div>
</form>

<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3"><div class="admin-panel stat-card"><div class="stat-label">Orders</div><div class="stat-value">{{ $summary['orders'] }}</div></div></div>
    <div class="col-sm-6 col-xl-3"><div class="admin-panel stat-card"><div class="stat-label">Paid orders</div><div class="stat-value">{{ $summary['paidOrders'] }}</div></div></div>
    <div class="col-sm-6 col-xl-3"><div class="admin-panel stat-card"><div class="stat-label">Revenue</div><div class="stat-value">₹{{ number_format($summary['revenue'], 2) }}</div></div></div>
    <div class="col-sm-6 col-xl-3"><div class="admin-panel stat-card"><div class="stat-label">Units sold</div><div class="stat-value">{{ $summary['units'] }}</div></div></div>
</div>

<div class="row g-4">
    <div class="col-lg-5"><section class="admin-panel p-3 h-100"><p class="admin-eyebrow mb-1">Daily pulse</p><h2 class="h4 mb-3">Orders by day</h2>@forelse($daily as $day => $dayOrders)<div class="d-flex justify-content-between py-2 border-bottom"><span>{{ $day }}</span><strong>{{ $dayOrders->count() }}</strong></div>@empty<p class="admin-muted">No orders in this range.</p>@endforelse</section></div>
    <div class="col-lg-7"><section class="admin-panel"><div class="p-3 border-bottom"><p class="admin-eyebrow mb-1">Order ledger</p><h2 class="h4 mb-0">Included orders</h2></div><div class="table-responsive"><table class="table admin-table mb-0"><thead><tr><th>Order</th><th>Customer</th><th>Status</th><th class="text-end">Total</th></tr></thead><tbody>@forelse($orders as $order)<tr><td>{{ $order->order_number }}<div class="admin-muted small">{{ $order->created_at?->format('d M Y') }}</div></td><td>{{ $order->user?->email ?: 'Guest' }}</td><td><span class="status-pill">{{ $order->status }}</span></td><td class="text-end">₹{{ number_format($order->total, 2) }}</td></tr>@empty<tr><td colspan="4" class="text-center admin-muted py-5">No orders in this range.</td></tr>@endforelse</tbody></table></div></section></div>
</div>
@endsection
