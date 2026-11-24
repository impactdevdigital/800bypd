@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-end gap-4">
        <div>
            <h1 class="font-fun text-[30px] sm:text-[42px] font-semibold text-ink leading-tight">Checkout & Order Placement</h1>
            <p class="text-[15px] text-slate-500">Complete your shipping details and select your preferred payment method.</p>
        </div>

        @guest
            <div class="bg-lilac text-ink px-4 py-3 rounded-2xl text-[13px] flex items-center gap-2 w-full md:w-auto">
                <i class="bi bi-info-circle-fill text-grape text-base flex-shrink-0"></i>
                <span>Have an account? <a href="{{ route('login') }}" class="font-bold underline">Log in</a> to auto-fill details!</span>
            </div>
        @else
            <div class="bg-lilac text-ink px-4 py-3 rounded-2xl text-[13px] font-bold flex items-center gap-2 w-full md:w-auto">
                <i class="bi bi-person-check-fill text-grape text-base flex-shrink-0"></i>
                <span>Logged in as {{ auth()->user()->name }}</span>
            </div>
        @endguest
    </div>

    <form action="{{ route('checkout.process') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 sm:gap-8">

            <div class="lg:col-span-8 space-y-5">
                <!-- Step 1 -->
                <div class="bg-white p-5 sm:p-7 rounded-[24px] shadow-soft">
                    <h3 class="font-fun font-semibold text-ink text-[20px] mb-5 flex items-center gap-3">
                        <span class="w-8 h-8 bg-ink text-sun rounded-full text-[13px] flex items-center justify-center font-sans font-bold">1</span>
                        Customer & Delivery Address
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="field-label">Full Name *</label>
                            <input type="text" name="customer_name" required value="{{ old('customer_name', auth()->user()->name ?? '') }}" placeholder="e.g. Adebayo Johnson" class="field">
                        </div>
                        <div>
                            <label class="field-label">Email Address *</label>
                            <input type="email" name="customer_email" required value="{{ old('customer_email', auth()->user()->email ?? '') }}" placeholder="e.g. adebayo@example.com" class="field">
                        </div>
                        <div class="md:col-span-2">
                            <label class="field-label">Phone Number (Required for Courier Delivery) *</label>
                            <input type="text" name="customer_phone" required value="{{ old('customer_phone', auth()->user()->phone ?? '') }}" placeholder="e.g. 08164254442" class="field">
                        </div>
                        <div class="md:col-span-2">
                            <label class="field-label">Delivery Address *</label>
                            <textarea name="shipping_address" rows="2" required placeholder="House number, street name, landmark..." class="field">{{ old('shipping_address') }}</textarea>
                        </div>
                        <div>
                            <label class="field-label">City / Town *</label>
                            <input type="text" name="city" required value="{{ old('city') }}" placeholder="e.g. Ikeja, Lekki" class="field">
                        </div>
                        <div>
                            <label class="field-label">State *</label>
                            <input type="text" name="state" required value="{{ old('state') }}" placeholder="e.g. Lagos, Rivers" class="field">
                        </div>
                        <div class="md:col-span-2">
                            <label class="field-label">Special Delivery Instructions / Notes (Optional)</label>
                            <textarea name="special_instructions" rows="2" placeholder="e.g. Please deliver after 2 PM or leave with security gate..." class="field">{{ old('special_instructions') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="bg-white p-5 sm:p-7 rounded-[24px] shadow-soft">
                    <h3 class="font-fun font-semibold text-ink text-[20px] mb-5 flex items-center gap-3">
                        <span class="w-8 h-8 bg-ink text-sun rounded-full text-[13px] flex items-center justify-center font-sans font-bold">2</span>
                        Shipping & Delivery Option
                    </h3>
                    <div class="grid sm:grid-cols-2 gap-3 text-[13px]">
                        <label class="flex items-start justify-between gap-3 p-4 border-2 border-ink/10 rounded-2xl cursor-pointer hover:border-grape/50 transition has-[:checked]:border-grape has-[:checked]:bg-lilac">
                            <div class="flex items-start gap-3">
                                <input type="radio" name="shipping_method" value="lagos_flat" checked onchange="updateShippingFee(2500)" class="mt-1 accent-[#7C3AED]">
                                <div>
                                    <p class="font-bold text-ink text-[14px]">Lagos Flat Rate Standard Delivery</p>
                                    <p class="text-[12px] text-slate-500 mt-0.5">Delivered within 1 - 3 business days across Lagos</p>
                                </div>
                            </div>
                            <span class="font-bold text-ink price-convertible flex-shrink-0" data-price-ngn="2500">₦2,500</span>
                        </label>
                        <label class="flex items-start justify-between gap-3 p-4 border-2 border-ink/10 rounded-2xl cursor-pointer hover:border-grape/50 transition has-[:checked]:border-grape has-[:checked]:bg-lilac">
                            <div class="flex items-start gap-3">
                                <input type="radio" name="shipping_method" value="nationwide_courier" onchange="updateShippingFee(4500)" class="mt-1 accent-[#7C3AED]">
                                <div>
                                    <p class="font-bold text-ink text-[14px]">Nationwide Express Courier (Outside Lagos)</p>
                                    <p class="text-[12px] text-slate-500 mt-0.5">Delivered via GIG / Red Star Courier (3 - 5 Days)</p>
                                </div>
                            </div>
                            <span class="font-bold text-ink price-convertible flex-shrink-0" data-price-ngn="4500">₦4,500</span>
                        </label>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="bg-white p-5 sm:p-7 rounded-[24px] shadow-soft">
                    <h3 class="font-fun font-semibold text-ink text-[20px] mb-5 flex items-center gap-3">
                        <span class="w-8 h-8 bg-ink text-sun rounded-full text-[13px] flex items-center justify-center font-sans font-bold">3</span>
                        Select Payment Gateway / Method
                    </h3>
                    <div class="space-y-3 text-[13px]">
                        <label class="flex items-center justify-between gap-3 p-4 border-2 border-ink/10 rounded-2xl cursor-pointer hover:border-grape/50 transition has-[:checked]:border-grape has-[:checked]:bg-lilac">
                            <div class="flex items-center gap-3">
                                <input type="radio" name="payment_method" value="paystack" checked onclick="toggleBankTransferUpload(false)" class="accent-[#7C3AED]">
                                <div>
                                    <p class="font-bold text-ink text-[14px]">Paystack (Instant Online Payment)</p>
                                    <p class="text-[12px] text-slate-500 mt-0.5">Instant approval via Bank Transfer, USSD, Cards or QR Code</p>
                                </div>
                            </div>
                            <span class="w-10 h-10 rounded-xl bg-white flex items-center justify-center flex-shrink-0"><i class="bi bi-lightning-charge-fill text-amber-500 text-lg"></i></span>
                        </label>
                        <label class="flex items-center justify-between gap-3 p-4 border-2 border-ink/10 rounded-2xl cursor-pointer hover:border-grape/50 transition has-[:checked]:border-grape has-[:checked]:bg-lilac">
                            <div class="flex items-center gap-3">
                                <input type="radio" name="payment_method" value="card" onclick="toggleBankTransferUpload(false)" class="accent-[#7C3AED]">
                                <div>
                                    <p class="font-bold text-ink text-[14px]">Debit / Credit Card (Visa, Mastercard, Verve)</p>
                                    <p class="text-[12px] text-slate-500 mt-0.5">Secure 3D Card authentication</p>
                                </div>
                            </div>
                            <span class="w-10 h-10 rounded-xl bg-white flex items-center justify-center flex-shrink-0"><i class="bi bi-credit-card-fill text-grape text-lg"></i></span>
                        </label>
                        <label class="flex items-center justify-between gap-3 p-4 border-2 border-ink/10 rounded-2xl cursor-pointer hover:border-grape/50 transition has-[:checked]:border-grape has-[:checked]:bg-lilac">
                            <div class="flex items-center gap-3">
                                <input type="radio" name="payment_method" value="bank_transfer" onclick="toggleBankTransferUpload(true)" class="accent-[#7C3AED]">
                                <div>
                                    <p class="font-bold text-ink text-[14px]">Direct GTBank Transfer (With Receipt Upload)</p>
                                    <p class="text-[12px] text-slate-500 mt-0.5">Transfer directly to GTBank & upload proof of payment</p>
                                </div>
                            </div>
                            <span class="w-10 h-10 rounded-xl bg-white flex items-center justify-center flex-shrink-0"><i class="bi bi-bank text-grape text-lg"></i></span>
                        </label>
                    </div>

                    <div id="bank_transfer_section" class="hidden mt-4 p-5 bg-peach rounded-2xl space-y-4 text-[13px]">
                        <div>
                            <p class="font-bold text-ink mb-2"><i class="bi bi-bank mr-1"></i> Bank Account for Transfer:</p>
                            <div class="grid sm:grid-cols-3 gap-2">
                                <div class="bg-white rounded-xl px-3 py-2.5"><span class="block text-[11px] text-slate-400 font-semibold">Bank Name</span><strong class="text-ink">{{ config('services.bank.name') }}</strong></div>
                                <div class="bg-white rounded-xl px-3 py-2.5"><span class="block text-[11px] text-slate-400 font-semibold">Account Number</span><strong class="font-mono text-[15px] text-ink">{{ config('services.bank.account_number') }}</strong></div>
                                <div class="bg-white rounded-xl px-3 py-2.5"><span class="block text-[11px] text-slate-400 font-semibold">Account Name</span><strong class="text-ink">{{ config('services.bank.account_name') }}</strong></div>
                            </div>
                        </div>
                        <div>
                            <label class="field-label">Upload Payment Receipt Screenshot *</label>
                            <input type="file" name="receipt" accept="image/*,.pdf" class="w-full text-[13px] bg-white p-2.5 rounded-xl file:mr-3 file:h-9 file:px-4 file:rounded-full file:border-0 file:bg-ink file:text-white file:font-bold file:text-[12px]">
                            <span class="text-[12px] text-slate-500 mt-1.5 block">Supported file formats: JPG, PNG, PDF (Max size 4MB)</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="lg:col-span-4">
                <div class="bg-white p-6 rounded-[24px] shadow-soft space-y-5 lg:sticky lg:top-28">
                    <div class="flex items-center justify-between">
                        <h3 class="font-fun font-semibold text-ink text-[22px]">Your Box</h3>
                        <span class="bg-mint text-emerald-800 text-[11px] font-bold px-2.5 py-1 rounded-full flex items-center gap-1">
                            <i class="bi bi-check-circle-fill text-emerald-600"></i> {{ $box['total_items'] ?? count($cart) }} Items (Full)
                        </span>
                    </div>

                    <div class="space-y-3 max-h-64 overflow-y-auto pr-1">
                        @foreach($cart as $item)
                            @php
                                $sumImg = $item['image'] ?? null;
                                if ($sumImg && !str_starts_with($sumImg, 'http') && !str_starts_with($sumImg, '/')) { $sumImg = asset('storage/' . $sumImg); }
                                $sumImg = $sumImg ?: asset('images/products/placeholder.svg');
                            @endphp
                            <div class="flex items-center gap-3">
                                <div class="relative w-14 h-14 rounded-xl bg-lilac p-1 flex items-center justify-center flex-shrink-0">
                                    <img src="{{ $sumImg }}" alt="" class="max-h-full max-w-full object-contain rounded" onerror="this.onerror=null; this.src='{{ asset('images/products/placeholder.svg') }}';">
                                    <span class="absolute -top-1.5 -right-1.5 bg-ink text-white text-[10px] font-bold w-5 h-5 rounded-full flex items-center justify-center">{{ $item['quantity'] }}</span>
                                </div>
                                <div class="min-w-0 flex-1 text-[12px]">
                                    <span class="font-bold text-ink block leading-tight line-clamp-2">{{ $item['name'] }}</span>
                                    @if(!empty($item['variation_name']))
                                        <span class="text-[11px] text-grape">{{ $item['variation_name'] }} • </span>
                                    @endif
                                    <span class="text-slate-400 text-[11px]">Qty: {{ $item['quantity'] }}</span>
                                </div>
                                <span class="font-extrabold text-ink text-[13px] flex-shrink-0">₦{{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                            </div>
                        @endforeach
                    </div>

                    <div class="space-y-2.5 text-[14px] border-t border-ink/10 pt-4">
                        <div class="flex justify-between text-slate-600">
                            <span>Items Subtotal</span>
                            <span class="font-bold text-ink price-convertible" data-price-ngn="{{ $subtotal }}">₦{{ number_format($subtotal, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-slate-600">
                            <span>Shipping Delivery Fee</span>
                            <span id="shippingFeeDisplay" class="font-bold text-ink price-convertible" data-price-ngn="2500">₦2,500</span>
                        </div>
                        <div class="flex justify-between items-baseline text-ink border-t border-ink/10 pt-3">
                            <span class="font-bold">Total Payable</span>
                            <span id="totalPayableDisplay" class="price-convertible font-fun font-semibold text-[26px]" data-price-ngn="{{ $subtotal + 2500 }}">₦{{ number_format($subtotal + 2500, 2) }}</span>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-ink hover:bg-inkdeep text-white font-bold h-[52px] rounded-full text-[14px] flex items-center justify-center gap-2 shadow-lift transition">
                        Place Order & Proceed <i class="bi bi-arrow-right"></i>
                    </button>

                    <div class="flex items-center justify-center gap-4 text-[11px] text-slate-400 font-semibold">
                        <span class="flex items-center gap-1"><i class="bi bi-shield-lock-fill text-emerald-500"></i> Paystack SSL Secured</span>
                        <span class="flex items-center gap-1"><i class="bi bi-credit-card-fill text-sun"></i> Cards, Direct Transfer &amp; USSD</span>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    let currentSubtotal = {{ $subtotal }};
    function toggleBankTransferUpload(show) {
        document.getElementById('bank_transfer_section').classList.toggle('hidden', !show);
    }

    function updateShippingFee(fee) {
        document.getElementById('shippingFeeDisplay').setAttribute('data-price-ngn', fee);
        document.getElementById('totalPayableDisplay').setAttribute('data-price-ngn', currentSubtotal + fee);

        const curr = sessionStorage.getItem('selected_currency') || 'NGN';
        changeCurrency(curr);
    }
</script>
@endsection
