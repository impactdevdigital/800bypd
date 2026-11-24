@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row items-start sm:items-end justify-between gap-3 mb-8">
        <div>
            <h1 class="font-fun text-[32px] sm:text-[44px] font-semibold text-ink leading-tight">Your Shopping Cart</h1>
            <p class="text-[15px] text-slate-500">Review your selected items and fill your box before checkout</p>
        </div>
        <a href="{{ route('catalog.index') }}" class="h-11 px-5 rounded-full bg-white shadow-soft text-ink font-bold text-[13px] flex items-center gap-2 hover:bg-lilac transition">
            <i class="bi bi-arrow-left"></i> Continue Shopping
        </a>
    </div>

    @if(session('error'))
        <div class="bg-rose-50 text-rose-900 p-4 sm:p-5 rounded-2xl text-[13px] flex items-center gap-3 mb-6">
            <span class="w-9 h-9 rounded-full bg-white flex items-center justify-center flex-shrink-0 text-rose-600"><i class="bi bi-exclamation-circle-fill"></i></span>
            <p class="font-bold">{{ session('error') }}</p>
        </div>
    @endif

    @if(session('success'))
        <div class="bg-mint text-emerald-900 p-4 rounded-2xl text-[13px] font-semibold flex items-center gap-2 mb-6">
            <i class="bi bi-check-circle-fill text-emerald-600 text-base"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(count($cart) > 0)
        <!-- FILL YOUR BOX PROGRESS -->
        <div class="rounded-[28px] p-5 sm:p-7 mb-6 {{ $box['is_box_full'] ? 'bg-mint' : 'bg-peach' }}">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-4">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-2xl rotate-3 {{ $box['is_box_full'] ? 'bg-emerald-500 text-white' : 'bg-sun text-ink' }}">
                        <i class="bi {{ $box['is_box_full'] ? 'bi-box2-heart-fill' : 'bi-box-seam-fill' }}"></i>
                    </div>
                    <div>
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="text-[10px] font-black uppercase tracking-wider px-2.5 py-1 rounded-full inline-flex items-center gap-1 bg-white {{ $box['is_box_full'] ? 'text-emerald-800' : 'text-amber-900' }}">
                                <i class="bi {{ $box['is_box_full'] ? 'bi-patch-check-fill text-emerald-600' : 'bi-box-seam text-amber-700' }}"></i>
                                <span>{{ $box['is_box_full'] ? 'Box Complete' : 'Fill Your Box Activity' }}</span>
                            </span>
                            <span class="text-[12px] font-bold text-slate-500">Min: {{ $box['required_minimum'] }} items</span>
                        </div>
                        <h2 class="font-fun font-semibold text-[24px] text-ink mt-1 leading-none">Fill Your Box</h2>
                    </div>
                </div>
                <div class="flex sm:flex-col items-baseline sm:items-end justify-between w-full sm:w-auto gap-2">
                    <span class="font-fun text-[32px] font-semibold leading-none {{ $box['is_box_full'] ? 'text-emerald-700' : 'text-grape' }}">
                        {{ $box['total_items'] }} <span class="text-base text-slate-400 font-medium">/ {{ $box['required_minimum'] }} items</span>
                    </span>
                    <span class="text-[12px] font-bold text-slate-500">{{ $box['is_box_full'] ? 'Ready for checkout!' : $box['remaining_items'] . ' more needed' }}</span>
                </div>
            </div>

            <div class="w-full bg-white rounded-full h-3 overflow-hidden mb-4">
                <div class="h-full rounded-full transition-all duration-500 ease-out {{ $box['is_box_full'] ? 'bg-emerald-500' : 'bg-gradient-to-r from-[#7C3AED] to-[#FACC15]' }}" style="width: {{ $box['progress_percent'] }}%"></div>
            </div>

            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 text-[13px]">
                <p class="font-semibold text-ink flex items-center gap-1.5">
                    <i class="bi {{ $box['is_box_full'] ? 'bi-stars text-amber-500' : 'bi-info-circle-fill text-grape' }} text-base"></i>
                    {{ $box['prompt_message'] }}
                </p>
                @if(!$box['is_box_full'])
                    <a href="{{ route('catalog.index') }}" class="bg-ink hover:bg-inkdeep text-white font-bold px-5 h-10 rounded-full text-[12px] transition inline-flex items-center gap-1.5 flex-shrink-0">
                        <i class="bi bi-plus-circle-fill text-sun"></i> Add Items to Fill Box
                    </a>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 sm:gap-8">
            <!-- Cart Items -->
            <div class="lg:col-span-8 space-y-3">
                @foreach($cart as $key => $item)
                    @php
                        $itemImg = $item['image'] ?? null;
                        if ($itemImg) {
                            if (!str_starts_with($itemImg, 'http') && !str_starts_with($itemImg, '/')) {
                                $itemImg = asset('storage/' . $itemImg);
                            }
                        } else {
                            $itemImg = asset('images/products/placeholder.svg');
                        }
                        $isBundle = isset($item['type']) && $item['type'] === 'bundle';
                    @endphp
                    <div class="bg-white p-3 sm:p-4 rounded-[24px] shadow-soft flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="flex items-start sm:items-center gap-4 min-w-0">
                            <div class="w-24 h-24 sm:w-28 sm:h-28 {{ $isBundle ? 'bg-peach' : 'bg-lilac' }} rounded-2xl overflow-hidden flex items-center justify-center flex-shrink-0 p-2">
                                <img src="{{ $itemImg }}" alt="{{ $item['name'] }}" class="max-h-full max-w-full object-contain rounded-md" onerror="this.onerror=null; this.src='{{ asset('images/products/placeholder.svg') }}';">
                            </div>
                            <div class="min-w-0 py-1">
                                <div class="flex flex-wrap items-center gap-1.5 mb-1.5">
                                    @if($isBundle)
                                        <span class="bg-sun text-ink text-[10px] font-black px-2 py-0.5 rounded-full uppercase tracking-wider">{{ $item['badge'] ?? 'Bundle Package' }}</span>
                                        <span class="bg-lilac text-grape text-[10px] font-bold px-2 py-0.5 rounded-full">Adds {{ $item['box_units_per_item'] }} items to box</span>
                                    @elseif(!empty($item['variation_name']))
                                        <span class="bg-lilac text-grape text-[11px] font-bold px-2 py-0.5 rounded-full">{{ $item['variation_name'] }}</span>
                                    @endif
                                </div>
                                <h4 class="font-fun font-semibold text-ink text-[18px] leading-snug mb-1">{{ $item['name'] }}</h4>
                                @if(!empty($item['items_breakdown']))
                                    <div class="text-[11px] text-slate-500 mb-2 flex flex-wrap items-center gap-1">
                                        <span class="font-bold text-slate-700 mr-0.5">Contains:</span>
                                        @foreach($item['items_breakdown'] as $component)
                                            <span class="inline-flex items-center gap-1 bg-lilac text-slate-600 px-1.5 py-0.5 rounded-md text-[10px]"><i class="bi bi-check2 text-emerald-600"></i> {{ $component }}</span>
                                        @endforeach
                                    </div>
                                @endif
                                <div class="flex items-center gap-1.5">
                                    <span class="text-[15px] font-extrabold text-ink price-convertible" data-price-ngn="{{ $item['price'] }}">₦{{ number_format($item['price'], 2) }}</span>
                                    @if($isBundle)
                                        <span class="text-[12px] text-slate-400">/ bundle</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-between sm:justify-end gap-3 border-t border-ink/5 sm:border-0 pt-3 sm:pt-0 sm:pr-2">
                            <form action="{{ route('cart.update', $key) }}" method="POST" class="flex items-center">
                                @csrf
                                <div class="flex items-center bg-lilac p-1 rounded-full text-sm font-bold">
                                    <button type="button" onclick="const input = this.parentNode.querySelector('input'); if(parseInt(input.value) > 1){ input.value = parseInt(input.value) - 1; this.form.submit(); }" class="w-9 h-9 rounded-full bg-white text-ink hover:bg-purple-100 transition flex items-center justify-center" aria-label="Decrease quantity">-</button>
                                    <input type="text" readonly name="quantity" value="{{ $item['quantity'] }}" class="w-9 text-center bg-transparent text-ink font-extrabold focus:outline-none" aria-label="Quantity">
                                    <button type="button" onclick="const input = this.parentNode.querySelector('input'); input.value = parseInt(input.value) + 1; this.form.submit();" class="w-9 h-9 rounded-full bg-white text-ink hover:bg-purple-100 transition flex items-center justify-center" aria-label="Increase quantity">+</button>
                                </div>
                            </form>
                            <form action="{{ route('cart.remove', $key) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-10 h-10 rounded-full text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition flex items-center justify-center" title="Remove item from box">
                                    <i class="bi bi-trash3 text-base"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Order Summary -->
            <div class="lg:col-span-4">
                <div class="bg-white p-6 rounded-[24px] shadow-soft space-y-5 lg:sticky lg:top-28">
                    <h3 class="font-fun font-semibold text-ink text-[22px]">Order Summary</h3>
                    <div class="space-y-3 text-[14px] text-slate-600">
                        <div class="flex justify-between items-center">
                            <span>Box Contents</span>
                            <span class="font-bold {{ $box['is_box_full'] ? 'text-emerald-700' : 'text-amber-600' }}">{{ $box['total_items'] }} / {{ $box['required_minimum'] }} items</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Subtotal</span>
                            <span class="font-bold text-ink price-convertible" data-price-ngn="{{ $subtotal }}">₦{{ number_format($subtotal, 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Estimated Shipping (Lagos)</span>
                            <span class="font-bold text-ink price-convertible" data-price-ngn="{{ $shippingFee }}">₦{{ number_format($shippingFee, 2) }}</span>
                        </div>
                        <div class="flex justify-between items-baseline text-ink border-t border-ink/10 pt-4">
                            <span class="font-bold">Total Payable</span>
                            <span class="price-convertible font-fun font-semibold text-[26px]" data-price-ngn="{{ $subtotal + $shippingFee }}">₦{{ number_format($subtotal + $shippingFee, 2) }}</span>
                        </div>
                    </div>

                    @if($box['is_box_full'])
                        <a href="{{ route('checkout.show') }}" class="w-full bg-ink hover:bg-inkdeep text-white font-bold h-[52px] rounded-full text-[14px] flex items-center justify-center gap-2 shadow-lift transition">
                            <span>Proceed to Checkout</span> <i class="bi bi-arrow-right"></i>
                        </a>
                        <p class="text-[12px] text-center text-emerald-700 font-bold flex items-center justify-center gap-1">
                            <i class="bi bi-shield-check"></i> Minimum order met! Ready to order.
                        </p>
                    @else
                        <button type="button" disabled class="w-full bg-slate-200 text-slate-400 font-bold h-[52px] rounded-full text-[14px] flex items-center justify-center gap-2 cursor-not-allowed">
                            <i class="bi bi-lock-fill"></i> Checkout Locked
                        </button>
                        <div class="bg-peach p-3.5 rounded-2xl text-[13px] text-amber-900 text-center">
                            Add <strong>{{ $box['remaining_items'] }}</strong> more {{ $box['remaining_items'] === 1 ? 'item' : 'items' }} to unlock checkout!
                        </div>
                        <a href="{{ route('catalog.index') }}" class="w-full bg-grape hover:bg-purple-800 text-white font-bold h-12 rounded-full text-[13px] flex items-center justify-center gap-1.5 transition">
                            <i class="bi bi-cart-plus-fill"></i> Browse Items to Fill Box
                        </a>
                    @endif

                    <div class="flex items-center justify-center gap-4 text-[11px] text-slate-400 font-semibold pt-1">
                        <span class="flex items-center gap-1"><i class="bi bi-shield-lock-fill text-emerald-500"></i> Paystack SSL Secured</span>
                        <span class="flex items-center gap-1"><i class="bi bi-flower1 text-pink-400"></i> Child-Safe</span>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="bg-white rounded-[32px] shadow-soft p-8 sm:p-14 text-center max-w-2xl mx-auto">
            <div class="relative w-56 h-36 mx-auto mb-6">
                <img src="{{ \App\Support\Img::sm('psalm_23_colouring_book_cover.jpg') }}" alt="" class="absolute left-4 top-2 w-20 rounded-lg shadow-lift -rotate-6">
                <img src="{{ \App\Support\Img::sm('affirmations_flashcards_cover.jpg') }}" alt="" class="absolute right-4 top-0 w-20 rounded-lg shadow-lift rotate-6">
                <img src="{{ \App\Support\Img::sm('easy_puzzle_2_cut.jpg') }}" alt="" class="absolute left-1/2 -translate-x-1/2 bottom-0 w-32 rounded-lg shadow-lift">
            </div>
            <h3 class="font-fun text-[26px] font-semibold text-ink mb-2">Your Box is Empty</h3>
            <p class="text-[14px] text-slate-500 max-w-sm mx-auto leading-relaxed mb-7">
                Start filling your box with fun jigsaw puzzles, educational flashcards, colouring books, or grab one of our ready-made bundles!
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-3">
                <a href="{{ route('home') }}#bundles-section" class="bg-sun hover:bg-yellow-300 text-ink font-bold px-6 h-12 rounded-full text-[13px] transition inline-flex items-center gap-1.5">
                    <i class="bi bi-box2-heart-fill"></i> Buy Pre-made Bundles
                </a>
                <a href="{{ route('catalog.index') }}" class="bg-ink text-white hover:bg-inkdeep font-bold px-6 h-12 rounded-full text-[13px] transition inline-flex items-center">
                    Browse All Products
                </a>
            </div>
        </div>
    @endif
</div>
@endsection
