<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function index(Request $request): View
    {
        [$from, $to] = $this->dateRange($request);
        $orders = $this->ordersBetween($from, $to);

        return view('admin.reports.index', [
            'from' => $from,
            'to' => $to,
            'orders' => $orders,
            'summary' => $this->summary($orders),
            'daily' => $orders->groupBy(fn (Order $order) => $order->created_at?->format('d M') ?? 'Unknown'),
        ]);
    }

    public function download(Request $request): Response
    {
        [$from, $to] = $this->dateRange($request);
        $orders = $this->ordersBetween($from, $to);
        $filename = 'acryluxe-orders-' . $from . '-to-' . $to . '.csv';

        return response()->streamDownload(function () use ($orders): void {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Order', 'Customer', 'Status', 'Payment', 'Subtotal', 'Shipping', 'Total', 'Created']);

            foreach ($orders as $order) {
                fputcsv($handle, [
                    $order->order_number,
                    $order->user?->email ?? 'Guest',
                    $order->status,
                    $order->payment_status,
                    $order->subtotal,
                    $order->shipping,
                    $order->total,
                    $order->created_at?->toDateTimeString(),
                ]);
            }

            fclose($handle);
        }, $filename, ['Content-Type' => 'text/csv']);
    }

    private function ordersBetween(string $from, string $to)
    {
        return Order::query()
            ->with(['user', 'items'])
            ->whereBetween('created_at', [$from . ' 00:00:00', $to . ' 23:59:59'])
            ->latest()
            ->get();
    }

    private function summary($orders): array
    {
        $paid = $orders->where('payment_status', 'paid');

        return [
            'orders' => $orders->count(),
            'paidOrders' => $paid->count(),
            'revenue' => (float) $paid->sum('total'),
            'units' => (int) $orders->flatMap->items->sum('quantity'),
        ];
    }

    private function dateRange(Request $request): array
    {
        $validated = $request->validate([
            'from' => ['nullable', 'date'],
            'to' => ['nullable', 'date', 'after_or_equal:from'],
        ]);

        return [
            $validated['from'] ?? now()->startOfMonth()->toDateString(),
            $validated['to'] ?? now()->toDateString(),
        ];
    }
}
