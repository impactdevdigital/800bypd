@extends('layouts.app')

@section('content')
@php
    $payBadge = function ($status) {
        if ($status === 'paid') return ['Paid', 'bg-mint text-emerald-700'];
        if ($status === 'pending_verification') return ['Receipt Pending', 'bg-peach text-amber-800'];
        return ['Unpaid', 'bg-rose-50 text-rose-700'];
    };
@endphp
<div class="max-w-6xl mx-auto space-y-6">
    <!-- Header -->
    <div class="relative rounded-[28px] sm:rounded-[36px] bg-ink text-white overflow-hidden p-6 sm:p-10">
        <div class="absolute inset-0 dots-bg opacity-[.12] pointer-events-none"></div>
        <div class="absolute -right-10 -bottom-20 w-72 h-72 rounded-full bg-grape/40 blur-2xl"></div>
        <div class="relative flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 sm:w-16 sm:h-16 bg-sun text-ink rounded-2xl flex items-center justify-center font-fun font-bold text-2xl rotate-3 flex-shrink-0">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div>
                    <h1 class="font-fun text-[26px] sm:text-[36px] font-semibold leading-tight">Hello, {{ $user->name }}!</h1>
                    <p class="text-[14px] text-indigo-200">Welcome to your 800BYPD customer portal</p>
                </div>
            </div>
            <div class="flex flex-wrap items-center gap-2.5 w-full md:w-auto">
                @if(in_array(auth()->user()->role, ['admin', 'staff']))
                    <a href="{{ route('admin.dashboard') }}" class="h-11 px-5 bg-grape hover:bg-purple-600 text-white font-bold rounded-full text-[13px] flex items-center gap-2 transition w-full sm:w-auto justify-center">
                        <i class="bi bi-speedometer2 text-sun"></i> Admin Overview Dashboard
                    </a>
                @endif
                <a href="{{ route('account.orders') }}" class="h-11 px-5 bg-sun hover:bg-yellow-300 text-ink font-bold rounded-full text-[13px] flex items-center gap-2 transition w-full sm:w-auto justify-center">
                    <i class="bi bi-archive-fill"></i> View Order History ({{ $ordersCount }})
                </a>
                <form action="{{ route('account.logout') }}" method="POST" class="w-full sm:w-auto">
                    @csrf
                    <button type="submit" class="h-11 px-5 bg-white/10 hover:bg-white/20 border border-white/15 text-white rounded-full text-[13px] font-bold transition w-full sm:w-auto flex items-center justify-center gap-1.5">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Profile & Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 sm:gap-5 text-[13px]">
        <div class="bg-white p-6 rounded-[24px] shadow-soft space-y-4">
            <div class="flex items-center justify-between">
                <span class="text-slate-400 font-bold uppercase tracking-wider text-[11px]">Account Profile</span>
                <span class="w-10 h-10 rounded-xl bg-lilac text-grape flex items-center justify-center"><i class="bi bi-person-vcard-fill"></i></span>
            </div>
            <div><p class="text-slate-500">Full Name</p><p class="font-bold text-ink text-[15px]">{{ $user->name }}</p></div>
            <div><p class="text-slate-500">Email Address</p><p class="font-bold text-ink break-all">{{ $user->email }}</p></div>
            <div><p class="text-slate-500">Phone Number</p><p class="font-bold text-ink">{{ $user->phone ?? 'Not provided' }}</p></div>
        </div>

        <div class="bg-peach p-6 rounded-[24px] flex flex-col">
            <div class="flex items-center justify-between">
                <span class="text-amber-900/60 font-bold uppercase tracking-wider text-[11px]">Total Orders Placed</span>
                <span class="w-10 h-10 rounded-xl bg-white text-amber-600 flex items-center justify-center"><i class="bi bi-bag-fill"></i></span>
            </div>
            <p class="font-fun text-[56px] font-semibold text-ink leading-none mt-4">{{ $ordersCount }}</p>
            <p class="text-slate-600 text-[13px] mt-auto pt-3">Track progress, delivery statuses & payment receipts.</p>
        </div>

        <div class="bg-lilac p-6 rounded-[24px] flex flex-col justify-between">
            <div class="space-y-2">
                <span class="text-grape/70 font-bold uppercase tracking-wider text-[11px]">Need Help?</span>
                <h3 class="font-fun text-[20px] font-semibold text-ink">Support & Delivery Info</h3>
                <p class="text-slate-600 text-[13px] leading-relaxed">Have questions about an existing order or delivery timeline?</p>
            </div>
            <a href="https://wa.me/2348164254442?text=Hello%20800bypd!%20I%20am%20logged%20in%20as%20{{ urlencode($user->email) }}%20and%20need%20help%20with%20my%20orders." target="_blank" class="mt-5 h-11 bg-[#25D366] hover:bg-emerald-600 text-white font-bold px-4 rounded-full text-[13px] flex items-center justify-center gap-2 transition">
                <i class="bi bi-whatsapp text-base"></i> Chat on WhatsApp
            </a>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="bg-white rounded-[24px] p-5 sm:p-8 shadow-soft">
        <div class="flex items-end justify-between gap-4 mb-6">
            <div>
                <h2 class="font-fun text-[24px] font-semibold text-ink">Recent Orders</h2>
                <p class="text-[13px] text-slate-500">Your latest purchases with 800byPD</p>
            </div>
            <a href="{{ route('account.orders') }}" class="text-grape hover:underline font-bold text-[13px] flex items-center gap-1 whitespace-nowrap">
                View All Orders <i class="bi bi-arrow-right text-[11px]"></i>
            </a>
        </div>

        @if($recentOrders->isEmpty())
            <div class="text-center py-12 bg-lilac rounded-[20px]">
                <div class="relative w-44 h-28 mx-auto mb-5">
                    <img src="{{ \App\Support\Img::sm('psalm_23_colouring_book_cover.jpg') }}" alt="" class="absolute left-3 top-1 w-16 rounded-lg shadow-lift -rotate-6">
                    <img src="{{ \App\Support\Img::sm('affirmations_flashcards_cover.jpg') }}" alt="" class="absolute right-3 top-0 w-16 rounded-lg shadow-lift rotate-6">
                    <img src="{{ \App\Support\Img::sm('easy_puzzle_1_cut.jpg') }}" alt="" class="absolute left-1/2 -translate-x-1/2 bottom-0 w-24 rounded-lg shadow-lift">
                </div>
                <h3 class="font-fun text-[20px] font-semibold text-ink">No orders yet</h3>
                <p class="text-[13px] text-slate-500 mb-5">Explore our collection of storybooks, jigsaw puzzles, and colouring books!</p>
                <a href="{{ route('catalog.index') }}" class="bg-ink hover:bg-inkdeep text-white font-bold px-6 h-12 rounded-full text-[13px] transition inline-flex items-center gap-2">
                    <i class="bi bi-book-half text-sun"></i> Browse Book Storefront
                </a>
            </div>
        @else
            <!-- Mobile cards -->
            <div class="md:hidden space-y-3">
                @foreach($recentOrders as $order)
                    @php [$payLabel, $payClass] = $payBadge($order->payment_status); @endphp
                    <a href="{{ route('account.orders.show', $order->order_number) }}" class="block bg-lilac/60 rounded-2xl p-4">
                        <div class="flex items-center justify-between mb-2">
                            <span class="font-bold text-ink">{{ $order->order_number }}</span>
                            <span class="font-bold text-ink price-convertible" data-price-ngn="{{ $order->total_amount }}">{{ $order->formatted_total }}</span>
                        </div>
                        <div class="flex items-center justify-between text-[12px]">
                            <span class="text-slate-500">{{ $order->created_at->format('M d, Y') }}</span>
                            <span class="flex gap-1.5">
                                <span class="{{ $payClass }} text-[10px] font-bold px-2 py-0.5 rounded-full uppercase">{{ $payLabel }}</span>
                                <span class="bg-white text-ink text-[10px] font-bold px-2 py-0.5 rounded-full uppercase">{{ ucfirst($order->order_status) }}</span>
                            </span>
                        </div>
                    </a>
                @endforeach
            </div>
            <!-- Desktop table -->
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full text-left text-[13px]">
                    <thead>
                        <tr class="text-slate-400 font-bold uppercase tracking-wider text-[11px]">
                            <th class="py-3 px-4">Order Number</th>
                            <th class="py-3 px-4">Date</th>
                            <th class="py-3 px-4">Total Amount</th>
                            <th class="py-3 px-4">Payment</th>
                            <th class="py-3 px-4">Status</th>
                            <th class="py-3 px-4 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-ink/5">
                        @foreach($recentOrders as $order)
                            @php [$payLabel, $payClass] = $payBadge($order->payment_status); @endphp
                            <tr class="hover:bg-lilac/50 transition">
                                <td class="py-4 px-4 font-bold text-ink whitespace-nowrap">{{ $order->order_number }}</td>
                                <td class="py-4 px-4 text-slate-500 whitespace-nowrap">{{ $order->created_at->format('M d, Y') }}</td>
                                <td class="py-4 px-4 font-bold text-ink price-convertible whitespace-nowrap" data-price-ngn="{{ $order->total_amount }}">{{ $order->formatted_total }}</td>
                                <td class="py-4 px-4"><span class="{{ $payClass }} text-[11px] font-bold px-2.5 py-1 rounded-full uppercase whitespace-nowrap">{{ $payLabel }}</span></td>
                                <td class="py-4 px-4"><span class="bg-lilac text-ink text-[11px] font-bold px-2.5 py-1 rounded-full uppercase">{{ ucfirst($order->order_status) }}</span></td>
                                <td class="py-4 px-4 text-right">
                                    <a href="{{ route('account.orders.show', $order->order_number) }}" class="bg-lilac hover:bg-purple-100 text-ink font-bold px-4 h-9 rounded-full text-[12px] transition inline-flex items-center gap-1">
                                        Details <i class="bi bi-chevron-right text-[10px]"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection
