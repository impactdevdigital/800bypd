@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end gap-4">
        <div>
            <a href="{{ route('account.dashboard') }}" class="text-[13px] text-grape font-bold hover:underline mb-2 inline-flex items-center gap-1">
                <i class="bi bi-arrow-left"></i> Back to Dashboard
            </a>
            <h1 class="font-fun text-[32px] sm:text-[42px] font-semibold text-ink leading-tight">Order History</h1>
            <p class="text-[14px] text-slate-500">Track and review all purchases placed under {{ $user->email }}</p>
        </div>
        <a href="{{ route('catalog.index') }}" class="bg-ink hover:bg-inkdeep text-white font-bold px-6 h-12 rounded-full text-[13px] transition flex items-center gap-2">
            <i class="bi bi-bag-fill text-sun"></i> Continue Shopping
        </a>
    </div>

    <div class="bg-white rounded-[24px] p-5 sm:p-8 shadow-soft">
        @if($orders->isEmpty())
            <div class="text-center py-14">
                <div class="w-16 h-16 rounded-2xl bg-peach text-amber-500 flex items-center justify-center text-3xl mx-auto mb-4"><i class="bi bi-box-seam"></i></div>
                <h2 class="font-fun text-[22px] font-semibold text-ink">No past orders found</h2>
                <p class="text-[13px] text-slate-500 mb-6">You haven't placed any orders with this account yet.</p>
                <a href="{{ route('catalog.index') }}" class="bg-ink text-white font-bold px-6 h-12 rounded-full text-[13px] inline-flex items-center">Start Shopping</a>
            </div>
        @else
            <!-- Mobile cards -->
            <div class="md:hidden space-y-3">
                @foreach($orders as $order)
                    <a href="{{ route('account.orders.show', $order->order_number) }}" class="block bg-lilac/60 rounded-2xl p-4 text-[13px]">
                        <div class="flex items-center justify-between mb-1">
                            <span class="font-bold text-ink">{{ $order->order_number }}</span>
                            <span class="font-bold text-ink price-convertible" data-price-ngn="{{ $order->total_amount }}">{{ $order->formatted_total }}</span>
                        </div>
                        <p class="text-[12px] text-slate-500 mb-2">{{ $order->created_at->format('M d, Y h:i A') }} · {{ $order->items->sum('quantity') }} items · {{ strtoupper(str_replace('_', ' ', $order->payment_method)) }}</p>
                        <div class="flex items-center justify-between">
                            <span class="flex gap-1.5">
                                @if($order->payment_status === 'paid')
                                    <span class="bg-mint text-emerald-700 text-[10px] font-bold px-2 py-0.5 rounded-full uppercase">Paid</span>
                                @elseif($order->payment_status === 'pending_verification')
                                    <span class="bg-peach text-amber-800 text-[10px] font-bold px-2 py-0.5 rounded-full uppercase">Pending Verification</span>
                                @else
                                    <span class="bg-rose-50 text-rose-700 text-[10px] font-bold px-2 py-0.5 rounded-full uppercase">Unpaid</span>
                                @endif
                                <span class="bg-white text-ink text-[10px] font-bold px-2 py-0.5 rounded-full uppercase">{{ ucfirst($order->order_status) }}</span>
                            </span>
                            <span class="text-grape font-bold text-[12px]">View Receipt <i class="bi bi-receipt"></i></span>
                        </div>
                    </a>
                @endforeach
            </div>

            <!-- Desktop table -->
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full text-left text-[13px]">
                    <thead>
                        <tr class="text-slate-400 font-bold uppercase tracking-wider text-[11px]">
                            <th class="py-3 px-4 whitespace-nowrap">Order #</th>
                            <th class="py-3 px-4 whitespace-nowrap">Date Placed</th>
                            <th class="py-3 px-4 whitespace-nowrap">Items Count</th>
                            <th class="py-3 px-4 whitespace-nowrap">Total Price</th>
                            <th class="py-3 px-4 whitespace-nowrap">Payment Method</th>
                            <th class="py-3 px-4 whitespace-nowrap">Payment Status</th>
                            <th class="py-3 px-4 whitespace-nowrap">Delivery Status</th>
                            <th class="py-3 px-4 text-right whitespace-nowrap">Details</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-ink/5">
                        @foreach($orders as $order)
                            <tr class="hover:bg-lilac/50 transition">
                                <td class="py-4 px-4 font-bold text-ink whitespace-nowrap">{{ $order->order_number }}</td>
                                <td class="py-4 px-4 text-slate-500 whitespace-nowrap">{{ $order->created_at->format('M d, Y h:i A') }}</td>
                                <td class="py-4 px-4 text-slate-700 font-bold whitespace-nowrap">{{ $order->items->sum('quantity') }} items</td>
                                <td class="py-4 px-4 font-bold text-ink price-convertible whitespace-nowrap" data-price-ngn="{{ $order->total_amount }}">{{ $order->formatted_total }}</td>
                                <td class="py-4 px-4 text-slate-600 uppercase text-[12px] font-bold whitespace-nowrap">{{ str_replace('_', ' ', $order->payment_method) }}</td>
                                <td class="py-4 px-4 whitespace-nowrap">
                                    @if($order->payment_status === 'paid')
                                        <span class="bg-mint text-emerald-700 text-[11px] font-bold px-2.5 py-1 rounded-full uppercase inline-flex items-center gap-1"><i class="bi bi-check-circle-fill"></i> Paid</span>
                                    @elseif($order->payment_status === 'pending_verification')
                                        <span class="bg-peach text-amber-800 text-[11px] font-bold px-2.5 py-1 rounded-full uppercase inline-flex items-center gap-1"><i class="bi bi-clock-fill"></i> Pending Verification</span>
                                    @else
                                        <span class="bg-rose-50 text-rose-700 text-[11px] font-bold px-2.5 py-1 rounded-full uppercase">Unpaid</span>
                                    @endif
                                </td>
                                <td class="py-4 px-4 whitespace-nowrap"><span class="bg-lilac text-ink text-[11px] font-bold px-2.5 py-1 rounded-full uppercase">{{ ucfirst($order->order_status) }}</span></td>
                                <td class="py-4 px-4 text-right whitespace-nowrap">
                                    <a href="{{ route('account.orders.show', $order->order_number) }}" class="bg-ink hover:bg-inkdeep text-white font-bold px-4 h-9 rounded-full text-[12px] transition inline-flex items-center gap-1.5">
                                        View Receipt <i class="bi bi-receipt text-sun"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="pt-6">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
