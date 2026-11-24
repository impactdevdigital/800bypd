@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="relative rounded-[32px] bg-lilac overflow-hidden text-center px-6 pt-10 pb-8 sm:px-10 mb-5">
        <div class="absolute -right-16 -top-16 w-56 h-56 rounded-full bg-sun/40"></div>
        <div class="absolute -left-10 -bottom-16 w-44 h-44 rounded-full bg-grape/10"></div>
        <div class="relative w-20 h-20 bg-white text-emerald-500 rounded-3xl flex items-center justify-center text-4xl mx-auto mb-5 shadow-soft rotate-3">
            <i class="bi bi-check-circle-fill"></i>
        </div>
        <h1 class="relative font-fun text-[32px] sm:text-[42px] font-semibold text-ink leading-tight mb-2">Order Confirmed!</h1>
        <p class="relative text-[15px] font-semibold text-slate-700">Your order has been confirmed! Please check your email for your order receipt.</p>
    </div>

    <div class="bg-white rounded-[24px] shadow-soft p-5 sm:p-6 mb-5 flex items-start gap-4">
        <div class="w-11 h-11 rounded-2xl bg-grape text-white flex items-center justify-center flex-shrink-0 text-xl">
            <i class="bi bi-envelope-check-fill"></i>
        </div>
        <div class="space-y-1">
            <h3 class="font-bold text-ink text-[15px]">Order Receipt Sent via Email</h3>
            <p class="text-[13px] text-slate-600 leading-relaxed">
                Your order has been confirmed! Please check your email inbox at <strong class="text-grape font-semibold">{{ $order->customer_email }}</strong> for your full order receipt and order summary.
            </p>
            <p class="text-[12px] text-slate-500 flex items-center gap-1.5 pt-0.5">
                <i class="bi bi-info-circle text-grape"></i> If you do not see it in your inbox shortly, please check your spam or junk folder.
            </p>
        </div>
    </div>

    <div class="bg-white rounded-[24px] shadow-soft p-5 sm:p-6 text-[13px] space-y-3 mb-5">
        <div class="flex justify-between items-center">
            <span class="text-slate-500 font-semibold">Order Number:</span>
            <span class="font-bold font-mono text-ink text-[15px]">{{ $order->order_number }}</span>
        </div>
        <div class="flex justify-between items-center">
            <span class="text-slate-500 font-semibold">Payment Method:</span>
            <span class="font-bold uppercase text-slate-800">{{ str_replace('_', ' ', $order->payment_method) }}</span>
        </div>
        <div class="flex justify-between items-center">
            <span class="text-slate-500 font-semibold">Payment Status:</span>
            <span class="font-bold px-3 py-1 rounded-full text-[11px] {{ $order->payment_status === 'paid' ? 'bg-mint text-emerald-700' : 'bg-peach text-amber-800' }}">
                {{ strtoupper($order->payment_status) }}
            </span>
        </div>
        <div class="flex justify-between items-baseline border-t border-ink/10 pt-4">
            <span class="text-ink font-bold">Total Amount Paid:</span>
            <span class="text-ink font-fun font-semibold text-[24px] price-convertible" data-price-ngn="{{ $order->total_amount }}">{{ $order->formatted_total }}</span>
        </div>
    </div>

    <div class="bg-white rounded-[24px] shadow-soft p-5 sm:p-6 text-[13px] mb-5">
        <h4 class="font-fun font-semibold text-ink text-[18px] flex items-center gap-2 mb-3">
            <i class="bi bi-box-seam-fill text-grape"></i> Items in Your Box ({{ $order->items->sum('quantity') }})
        </h4>
        <div class="divide-y divide-ink/5">
            @foreach($order->items as $item)
                <div class="py-3 flex items-start justify-between gap-3">
                    <div>
                        <div class="font-bold text-slate-800 flex items-center flex-wrap gap-1.5">
                            <span>{{ $item->product_name }}</span>
                            @if($item->variation_name)
                                <span class="text-[11px] bg-lilac text-grape px-2 py-0.5 rounded-full font-bold">{{ $item->variation_name }}</span>
                            @endif
                            @if($item->bundle_id)
                                <span class="text-[11px] bg-peach text-amber-900 px-2 py-0.5 rounded-full font-bold inline-flex items-center gap-1">
                                    <i class="bi bi-gift-fill text-amber-500"></i> Bundle
                                </span>
                            @endif
                        </div>
                        @if($item->bundle_details)
                            <p class="text-[12px] text-slate-500 mt-0.5">Includes: {{ $item->bundle_details }}</p>
                        @endif
                    </div>
                    <span class="font-bold text-ink whitespace-nowrap bg-lilac px-2.5 py-1 rounded-full text-[12px]">x{{ $item->quantity }}</span>
                </div>
            @endforeach
        </div>
    </div>

    @if($order->payment_method === 'bank_transfer')
        <div class="bg-peach text-ink p-5 rounded-[24px] text-[13px] mb-5 flex items-start gap-3">
            <i class="bi bi-info-circle-fill text-base text-grape flex-shrink-0 mt-0.5"></i>
            <div>
                <strong>Bank Transfer Status:</strong> Your payment receipt screenshot has been uploaded. An administrator will verify your receipt and dispatch your package shortly.
            </div>
        </div>
    @endif

    <div class="text-center pt-2">
        <a href="{{ route('home') }}" class="bg-ink hover:bg-inkdeep text-white font-bold px-7 h-12 rounded-full text-[14px] inline-flex items-center gap-2 shadow-lift transition">Return to Storefront <i class="bi bi-arrow-right text-sun"></i></a>
    </div>
</div>
@endsection
