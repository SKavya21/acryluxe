@extends('admin.layout')

@section('title', 'Orders')
@section('section', 'Orders')

@section('content')
<div class="container py-4">
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1">Orders</h1>
            <p class="text-muted mb-0">Track payment status, fulfillment progress, and order items.</p>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Order</th>
                        <th>Customer</th>
                        <th>Items</th>
                        <th>Total</th>
                        <th>Payment</th>
                        <th>Status</th>
                        <th>Placed</th>
                        <th>Update</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td>
                                <div class="fw-semibold">{{ $order->order_number }}</div>
                                <div class="small text-muted">{{ $order->payment_method ?: 'n/a' }}</div>
                            </td>
                            <td>
                                {{ $order->user?->name ?: 'Guest' }}
                                <div class="small text-muted">{{ $order->user?->email }}</div>
                            </td>
                            <td>
                                <ul class="list-unstyled mb-0 small">
                                    @foreach($order->items as $item)
                                        <li>{{ $item->product_name }} x {{ $item->quantity }}</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td>₹{{ number_format($order->total, 2) }}</td>
                            <td>{{ ucfirst($order->payment_status) }}</td>
                            <td>{{ ucfirst($order->status) }}</td>
                            <td>{{ optional($order->placed_at)->format('d M Y, h:i A') ?: 'Pending' }}</td>
                            <td>
                                <form action="{{ route('admin.orders.update', $order) }}" method="POST" class="d-flex gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" class="form-select form-select-sm">
                                        @foreach(['pending', 'processing', 'shipped', 'completed', 'cancelled'] as $status)
                                            <option value="{{ $status }}" @selected($order->status === $status)>{{ ucfirst($status) }}</option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="btn btn-sm btn-outline-dark">Save</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">No orders yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
