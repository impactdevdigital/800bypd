@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto space-y-5">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end gap-4">
        <div>
            <a href="{{ route('account.orders') }}" class="text-[13px] text-grape font-bold hover:underline mb-2 inline-flex items-center gap-1">
                <i class="bi bi-arrow-left"></i> Back to All Orders
            </a>
            <h1 class="font-fun text-[28px] sm:text-[38px] font-semibold text-ink leading-tight">Order #{{ $order->order_number }}</h1>
            <p class="text-[14px] text-slate-500">Placed on {{ $order->created_at->format('F j, Y \a\t g:i A') }}</p>
        </div>
        <button onclick="window.print()" class="bg-white shadow-soft hover:bg-lilac text-ink font-bold px-5 h-11 rounded-full text-[13px] flex items-center gap-2 transition print:hidden">
            <i class="bi bi-printer-fill text-grape"></i> Print Order Receipt
        </button>
    </div>

    <!-- Progress -->
    <div class="bg-white p-5 sm:p-8 rounded-[24px] shadow-soft">
        <h3 class="font-fun text-[20px] font-semibold text-ink mb-4">Order Progress</h3>
        @php
            $statuses = ['pending', 'processing', 'dispatched', 'delivered'];
            $statusIcons = ['bi-hourglass-split', 'bi-box-seam', 'bi-truck', 'bi-house-heart'];
            $currentIndex = array_search($order->order_status, $statuses);
            if ($currentIndex === false) $currentIndex = 0;
        @endphp
        <div class="relative flex items-start justify-between max-w-2xl mx-auto py-4">
            <div class="absolute top-[38px] left-[6%] right-[6%] h-1.5 bg-lilac rounded-full"></div>
            <div class="absolute top-[38px] left-[6%] h-1.5 bg-grape rounded-full transition-all duration-500" style="width: {{ ($currentIndex / (count($statuses) - 1)) * 88 }}%"></div>
            @foreach($statuses as $index => $st)
                @php $isCompleted = $index <= $currentIndex; $isCurrent = $index === $currentIndex; @endphp
                <div class="relative z-10 flex flex-col items-center w-1/4">
                    <div class="w-11 h-11 sm:w-12 sm:h-12 rounded-full flex items-center justify-center text-base transition-all {{ $isCompleted ? 'bg-grape text-white' : 'bg-white text-slate-400 ring-2 ring-lilac' }} {{ $isCurrent ? 'ring-4 ring-grape/20' : '' }}">
                        @if($isCompleted && !$isCurrent)
                            <i class="bi bi-check-lg"></i>
                        @else
                            <i class="bi {{ $statusIcons[$index] }}"></i>
                        @endif
                    </div>
                    <span class="text-[12px] font-bold capitalize mt-2 {{ $isCompleted ? 'text-ink' : 'text-slate-400' }}">{{ $st }}</span>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Items -->
    <div class="bg-white p-5 sm:p-8 rounded-[24px] shadow-soft">
        <h3 class="font-fun text-[22px] font-semibold text-ink mb-2">Items Purchased</h3>
        <div class="divide-y divide-ink/5">
            @foreach($order->items as $item)
                <div class="py-4 flex justify-between items-center gap-3 text-[13px]">
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 {{ $item->bundle_id ? 'bg-peach text-amber-600' : 'bg-lilac text-grape' }} rounded-xl flex items-center justify-center text-base flex-shrink-0">
                            <i class="bi {{ $item->bundle_id ? 'bi-box2-heart-fill' : 'bi-box-seam' }}"></i>
                        </div>
                        <div>
                            <p class="font-bold text-ink text-[14px] flex items-center flex-wrap gap-1.5">
                                <span>{{ $item->product_name }}</span>
                                @if($item->variation_name)
                                    <span class="text-[11px] bg-lilac text-grape px-2 py-0.5 rounded-full font-bold">{{ $item->variation_name }}</span>
                                @endif
                                @if($item->bundle_id)
                                    <span class="text-[11px] bg-peach text-amber-900 px-2 py-0.5 rounded-full font-bold inline-flex items-center gap-1"><i class="bi bi-box2-heart-fill text-amber-500"></i> Bundle</span>
                                @endif
                            </p>
                            @if($item->bundle_details)
                                <p class="text-[12px] text-slate-500 mt-0.5 leading-snug">Includes: {{ $item->bundle_details }}</p>
                            @endif
                            <p class="text-slate-500 mt-0.5">Unit Price: <span class="price-convertible" data-price-ngn="{{ $item->price }}">₦{{ number_format($item->price, 2) }}</span> &times; {{ $item->quantity }}</p>
                        </div>
                    </div>
                    <p class="font-bold text-ink text-[14px] price-convertible whitespace-nowrap" data-price-ngn="{{ $item->price * $item->quantity }}">₦{{ number_format($item->price * $item->quantity, 2) }}</p>
                </div>
            @endforeach
        </div>

        <div class="border-t border-ink/10 pt-4 mt-2 space-y-2.5 text-[14px] text-slate-600">
            <div class="flex justify-between"><span>Subtotal</span><span class="price-convertible" data-price-ngn="{{ $order->subtotal }}">{{ $order->formatted_subtotal }}</span></div>
            <div class="flex justify-between gap-3"><span>Shipping Fee ({{ $order->shipping_method === 'nationwide_courier' ? 'Nationwide Courier' : 'Lagos Flat Rate' }})</span><span class="price-convertible whitespace-nowrap" data-price-ngn="{{ $order->shipping_fee }}">₦{{ number_format($order->shipping_fee, 2) }}</span></div>
            @if($order->discount_amount > 0)
                <div class="flex justify-between text-grape"><span>Discount</span><span class="price-convertible" data-price-ngn="{{ $order->discount_amount }}">-₦{{ number_format($order->discount_amount, 2) }}</span></div>
            @endif
            <div class="flex justify-between items-baseline border-t border-ink/10 pt-3 text-ink">
                <span class="font-bold">Total Paid / Due</span>
                <span class="price-convertible font-fun font-semibold text-[26px]" data-price-ngn="{{ $order->total_amount }}">{{ $order->formatted_total }}</span>
            </div>
        </div>
    </div>

    <!-- Shipping & Payment -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 text-[13px]">
        <div class="bg-white p-6 rounded-[24px] shadow-soft space-y-4">
            <div class="flex items-center justify-between">
                <h4 class="font-fun text-[18px] font-semibold text-ink">Shipping Details</h4>
                <span class="w-10 h-10 rounded-xl bg-lilac text-grape flex items-center justify-center"><i class="bi bi-truck"></i></span>
            </div>
            <div><p class="text-slate-400 font-bold uppercase tracking-wider text-[11px]">Recipient Name</p><p class="font-bold text-ink">{{ $order->customer_name }}</p></div>
            <div><p class="text-slate-400 font-bold uppercase tracking-wider text-[11px]">Phone Number</p><p class="font-bold text-ink">{{ $order->customer_phone }}</p></div>
            <div><p class="text-slate-400 font-bold uppercase tracking-wider text-[11px]">Delivery Address</p><p class="font-bold text-ink">{{ $order->shipping_address }}, {{ $order->city }}, {{ $order->state }}</p></div>
            @if($order->special_instructions)
                <div><p class="text-slate-400 font-bold uppercase tracking-wider text-[11px] mb-1">Delivery Note</p><p class="text-slate-700 bg-lilac p-3 rounded-xl">{{ $order->special_instructions }}</p></div>
            @endif
        </div>

        <div class="bg-white p-6 rounded-[24px] shadow-soft space-y-4">
            <div class="flex items-center justify-between">
                <h4 class="font-fun text-[18px] font-semibold text-ink">Payment Details</h4>
                <span class="w-10 h-10 rounded-xl bg-peach text-amber-600 flex items-center justify-center"><i class="bi bi-credit-card-fill"></i></span>
            </div>
            <div><p class="text-slate-400 font-bold uppercase tracking-wider text-[11px]">Payment Method</p><p class="font-bold text-ink uppercase">{{ str_replace('_', ' ', $order->payment_method) }}</p></div>
            <div>
                <p class="text-slate-400 font-bold uppercase tracking-wider text-[11px]">Payment Status</p>
                <p class="font-bold">
                    @if($order->payment_status === 'paid')
                        <span class="text-emerald-700 flex items-center gap-1"><i class="bi bi-check-circle-fill"></i> Paid</span>
                    @elseif($order->payment_status === 'pending_verification')
                        <span class="text-amber-600 flex items-center gap-1"><i class="bi bi-clock-fill"></i> Pending Verification</span>
                    @else
                        <span class="text-rose-600">Unpaid</span>
                    @endif
                </p>
            </div>
            @if($order->payment_reference)
                <div><p class="text-slate-400 font-bold uppercase tracking-wider text-[11px]">Transaction Reference</p><p class="font-mono text-slate-700 bg-lilac px-2.5 py-1 rounded-lg inline-block text-[12px] mt-1 break-all">{{ $order->payment_reference }}</p></div>
            @endif
            @if($order->bank_transfer_receipt)
                <div>
                    <p class="text-slate-400 font-bold uppercase tracking-wider text-[11px]">Bank Transfer Receipt</p>
                    <a href="{{ asset('storage/' . $order->bank_transfer_receipt) }}" target="_blank" class="text-grape font-bold hover:underline flex items-center gap-1 mt-1">
                        <i class="bi bi-file-earmark-text-fill"></i> View Uploaded Receipt
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
