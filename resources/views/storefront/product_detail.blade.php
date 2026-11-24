@extends('layouts.app')

@section('content')
@php
    $catName = strtolower($product->category->name ?? '');
    $isPuzzle = str_contains($catName, 'puzzle');
    $isFlashcard = str_contains($catName, 'flashcard');
    $isColouring = str_contains($catName, 'colouring') || str_contains($catName, 'coloring');
    $stageBg = $isPuzzle ? 'bg-peach' : ($isColouring ? 'bg-blush' : ($isFlashcard ? 'bg-lilac' : 'bg-ink'));
    $gallery = $product->gallery_images;
@endphp

<!-- Breadcrumbs -->
<nav class="text-[13px] text-slate-500 font-semibold flex items-center flex-wrap gap-2 mb-6">
    <a href="{{ route('home') }}" class="hover:text-grape transition flex items-center gap-1.5">
        <i class="bi bi-house-door-fill text-slate-400"></i> <span>Home</span>
    </a>
    <i class="bi bi-chevron-right text-[10px] text-slate-300"></i>
    @if($product->category)
        <a href="{{ route('catalog.index', ['category' => $product->category->slug]) }}" class="hover:text-grape transition">{{ $product->category->name }}</a>
    @else
        <a href="{{ route('catalog.index') }}" class="hover:text-grape transition">Products</a>
    @endif
    <i class="bi bi-chevron-right text-[10px] text-slate-300"></i>
    <span class="text-ink font-bold truncate max-w-[220px] sm:max-w-md">{{ $product->name }}</span>
</nav>

@if(session('success'))
    <div class="mb-6 bg-mint text-emerald-900 px-5 py-3.5 rounded-2xl text-[13px] font-bold flex items-center gap-2">
        <i class="bi bi-check-circle-fill text-emerald-600 text-base"></i>
        <span>{{ session('success') }}</span>
    </div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12">

    <!-- Image Gallery -->
    <div class="lg:col-span-7">
        <div class="lg:sticky lg:top-28">
            <div class="aspect-[4/3] {{ $stageBg }} rounded-[28px] sm:rounded-[36px] overflow-hidden relative flex items-center justify-center p-6 sm:p-10">
                <div class="absolute -right-16 -bottom-16 w-64 h-64 rounded-full bg-white/30"></div>
                <img id="mainProductImage"
                     src="{{ $product->image_url }}"
                     alt="{{ $product->name }}"
                     class="relative max-h-full max-w-full object-contain drop-shadow-2xl rounded-xl"
                     onerror="this.onerror=null; this.src='{{ asset('images/products/placeholder.svg') }}';">
            </div>

            @if($gallery->count() > 1)
                <div class="flex gap-3 overflow-x-auto scrollbar-none mt-4 pb-1">
                    @foreach($gallery as $img)
                        <button type="button"
                                onclick="document.getElementById('mainProductImage').src = this.querySelector('img').src; document.querySelectorAll('.gallery-thumb').forEach(t => t.classList.remove('ring-2','ring-grape')); this.classList.add('ring-2','ring-grape');"
                                class="gallery-thumb w-20 h-20 sm:w-24 sm:h-24 {{ $stageBg }} rounded-2xl p-1.5 flex items-center justify-center flex-shrink-0 transition hover:-translate-y-0.5 {{ $loop->first ? 'ring-2 ring-grape' : '' }}">
                            <img src="{{ $img->sm_url }}" alt="" class="max-h-full max-w-full object-contain rounded-lg" onerror="this.onerror=null; this.src='{{ asset('images/products/placeholder.svg') }}';">
                        </button>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <!-- Product Details -->
    <div class="lg:col-span-5 flex flex-col">
        <div class="flex items-center flex-wrap gap-2 mb-4">
            @if($product->category)
                <a href="{{ route('catalog.index', ['category' => $product->category->slug]) }}" class="text-[11px] font-bold uppercase tracking-[.12em] text-ink bg-sun hover:bg-yellow-300 px-3 py-1.5 rounded-full inline-flex items-center gap-1.5 transition">
                    <i class="bi bi-tag-fill"></i> <span>{{ $product->category->name }}</span>
                </a>
            @else
                <span class="text-[11px] font-bold uppercase tracking-[.12em] text-grape bg-lilac px-3 py-1.5 rounded-full">Children's Store</span>
            @endif

            @if($product->stock_quantity > 0)
                <span id="stockBadge" class="bg-mint text-emerald-800 text-[12px] font-bold px-3 py-1.5 rounded-full flex items-center gap-1.5">
                    <i class="bi bi-check-circle-fill text-emerald-600"></i> <span id="stockDisplay">In Stock</span>
                </span>
            @else
                <span id="stockBadge" class="bg-rose-50 text-rose-800 text-[12px] font-bold px-3 py-1.5 rounded-full flex items-center gap-1.5">
                    <i class="bi bi-x-circle-fill text-rose-600"></i> <span id="stockDisplay">Out of Stock</span>
                </span>
            @endif

            @if($product->variants->count() > 0)
                <span class="text-[11px] font-bold uppercase tracking-wider text-amber-800 bg-peach px-3 py-1.5 rounded-full">Multiple Variations</span>
            @endif
        </div>

        <h1 class="font-fun text-[30px] sm:text-[38px] font-semibold text-ink leading-[1.1] mb-3">{{ $product->name }}</h1>

        @php $avgRating = round($product->reviews->avg('rating') ?: 5); @endphp
        <div class="flex items-center gap-2 mb-5">
            <div class="flex text-sun text-sm gap-0.5">
                @for($i = 1; $i <= 5; $i++)
                    <i class="bi {{ $i <= $avgRating ? 'bi-star-fill' : 'bi-star' }}"></i>
                @endfor
            </div>
            <a href="#reviews-section" class="text-[13px] text-slate-500 hover:text-grape font-semibold underline underline-offset-2">
                {{ $product->reviews->count() }} {{ Str::plural('Review', $product->reviews->count()) }}
            </a>
        </div>

        <div class="flex items-baseline flex-wrap gap-3 mb-5">
            <span id="priceDisplay" class="font-fun text-[36px] font-semibold text-ink price-convertible leading-none" data-price-ngn="{{ $product->variants->first()?->price ?? ($product->sale_price ?? $product->price) }}">
                ₦{{ number_format($product->variants->first()?->price ?? ($product->sale_price ?? $product->price), 2) }}
            </span>
            @if($product->sale_price && $product->variants->isEmpty())
                <span class="text-base text-slate-400 line-through price-convertible" data-price-ngn="{{ $product->price }}">{{ $product->formatted_original_price }}</span>
                <span class="bg-sun text-ink text-[12px] font-bold px-3 py-1 rounded-full">Special Offer</span>
            @endif
        </div>

        <div class="text-[14px] text-ink bg-lilac p-4 rounded-2xl mb-6 flex items-start gap-3">
            <i class="bi bi-stars text-amber-500 text-lg leading-none mt-0.5 flex-shrink-0"></i>
            <div><strong>Why Kids & Parents Love This:</strong> Crafted to stimulate imagination, problem-solving, and faith-filled learning in young minds.</div>
        </div>

        <form id="productAddToCartForm" action="{{ route('cart.add', $product->id) }}" method="POST" onsubmit="handleProductDetailAddToCart(event)" class="space-y-5 mb-6">
            @csrf

            @if($product->variants->count() > 0)
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <label class="text-[14px] font-bold text-ink flex items-center gap-1.5">
                            <i class="bi bi-sliders2-vertical text-grape"></i>
                            @if($isPuzzle)
                                Select Difficulty / Pieces:
                            @elseif($isFlashcard)
                                Select Card Size:
                            @else
                                Select Option / Variation:
                            @endif
                        </label>
                        <span class="text-[12px] text-slate-500 font-semibold">Choose your variation</span>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                        @foreach($product->variants as $index => $variant)
                            <label class="variant-pill-label relative flex items-center justify-between gap-3 p-4 rounded-2xl border-2 cursor-pointer transition bg-white {{ $index === 0 ? 'border-grape shadow-soft' : 'border-transparent shadow-soft hover:border-purple-200' }}">
                                <input type="radio" name="variant_id" value="{{ $variant->id }}" {{ $index === 0 ? 'checked' : '' }}
                                       data-price="{{ $variant->price }}" data-stock="{{ $variant->stock }}" data-name="{{ $variant->name }}"
                                       onchange="handleVariantSelection(this)" class="sr-only">
                                <div class="flex items-center gap-2.5">
                                    <span class="w-5 h-5 rounded-full border-2 border-slate-300 flex items-center justify-center variant-indicator flex-shrink-0">
                                        <span class="w-2.5 h-2.5 rounded-full bg-grape {{ $index === 0 ? '' : 'hidden' }}"></span>
                                    </span>
                                    <span class="font-bold text-[14px] text-ink leading-tight">{{ $variant->name }}</span>
                                </div>
                                <span class="text-[13px] font-extrabold text-grape whitespace-nowrap">₦{{ number_format($variant->price, 2) }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="flex items-center gap-3">
                <div class="flex items-center bg-white p-1 rounded-full shadow-soft text-sm font-bold" aria-label="Quantity">
                    <button type="button" onclick="changeProductDetailQty(-1)" class="w-11 h-11 rounded-full text-ink hover:bg-lilac transition flex items-center justify-center text-lg" aria-label="Decrease quantity">-</button>
                    <span id="productDetailQtyDisplay" class="w-8 text-center text-ink font-extrabold">1</span>
                    <button type="button" onclick="changeProductDetailQty(1)" class="w-11 h-11 rounded-full text-ink hover:bg-lilac transition flex items-center justify-center text-lg" aria-label="Increase quantity">+</button>
                    <input type="hidden" name="quantity" id="productDetailQtyInput" value="1">
                </div>
                <button type="submit" id="productDetailAddBtn" class="flex-1 bg-ink hover:bg-inkdeep text-white font-bold h-[52px] rounded-full shadow-lift transition text-[15px] flex items-center justify-center gap-2">
                    <i class="bi bi-box-seam-fill text-sun"></i>
                    <span id="productDetailBtnText">Add to My Box</span>
                </button>
            </div>
        </form>

        <div class="grid grid-cols-3 gap-2 text-center text-[12px] text-slate-600">
            <div class="bg-white rounded-2xl p-3 shadow-soft">
                <i class="bi bi-truck text-grape text-lg mb-1 block"></i>
                <span class="font-bold block text-ink">1-3 Days Delivery</span>
                <span class="text-[11px] text-slate-400">Lagos & Nationwide</span>
            </div>
            <div class="bg-white rounded-2xl p-3 shadow-soft">
                <i class="bi bi-shield-check text-grape text-lg mb-1 block"></i>
                <span class="font-bold block text-ink">Secure Payment</span>
                <span class="text-[11px] text-slate-400">Paystack & Bank Transfer</span>
            </div>
            <div class="bg-white rounded-2xl p-3 shadow-soft">
                <i class="bi bi-box2-heart text-grape text-lg mb-1 block"></i>
                <span class="font-bold block text-ink">Fills Your Box</span>
                <span class="text-[11px] text-slate-400">Counts Toward Minimum</span>
            </div>
        </div>
    </div>
</div>

<!-- Product Overview & Details -->
<section class="mt-16 sm:mt-20">
    <div class="grid lg:grid-cols-12 gap-8">
        <div class="lg:col-span-5">
            <h2 class="font-fun text-[28px] sm:text-[32px] font-semibold text-ink leading-tight mb-4">Product Overview & Details</h2>
            <p class="text-[15px] text-slate-600 leading-relaxed">{{ $product->description }}</p>
        </div>
        <div class="lg:col-span-7 grid sm:grid-cols-3 gap-4">
            <div class="bg-lilac p-5 rounded-[24px]">
                <span class="w-10 h-10 rounded-xl bg-white text-grape flex items-center justify-center mb-3"><i class="bi bi-person-heart"></i></span>
                <h3 class="text-[14px] font-bold text-ink mb-1.5">Recommended Age & Level</h3>
                <p class="text-[13px] text-slate-600 leading-relaxed">
                    @if($isPuzzle)
                        <strong>Ages 3–8 yrs</strong> (Easy: 3–5 yrs, Intermediate: 5–8 yrs). Promotes hand-eye coordination, spatial awareness, and problem solving.
                    @elseif($isFlashcard)
                        <strong>Ages 2–6 yrs</strong> (Pocket & Big). Daily biblical identity affirmations and early vocabulary recognition.
                    @elseif($isColouring)
                        <strong>Ages 3–8 yrs</strong>. Heavyweight, premium paper perfect for crayons, coloured pencils, and light felt-tip markers.
                    @else
                        <strong>Ages 3–9 yrs</strong>. Engaging character-building stories designed for read-aloud family devotionals.
                    @endif
                </p>
            </div>
            <div class="bg-peach p-5 rounded-[24px]">
                <span class="w-10 h-10 rounded-xl bg-white text-amber-600 flex items-center justify-center mb-3"><i class="bi bi-award"></i></span>
                <h3 class="text-[14px] font-bold text-ink mb-1.5">Faith & Skills Supported</h3>
                <p class="text-[13px] text-slate-600 leading-relaxed">Scripture memorization, confidence in God's love, patience, fine motor dexterity, and independent active play.</p>
            </div>
            <div class="bg-mint p-5 rounded-[24px]">
                <span class="w-10 h-10 rounded-xl bg-white text-emerald-600 flex items-center justify-center mb-3"><i class="bi bi-shield-check"></i></span>
                <h3 class="text-[14px] font-bold text-ink mb-1.5">Materials & Safety Guidance</h3>
                <p class="text-[13px] text-slate-600 leading-relaxed">100% non-toxic vegetable inks, thick rounded-corner boards, child-safe construction. Adult supervision recommended for small puzzle pieces under 3 yrs.</p>
            </div>
        </div>
    </div>

    @if($product->variants->count() > 0)
        <div class="mt-8 bg-white p-6 rounded-[24px] shadow-soft">
            <h3 class="font-fun font-semibold text-lg text-ink flex items-center gap-2 mb-4">
                <i class="bi bi-info-circle-fill text-grape"></i> About Available Variations
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-[13px] text-slate-600">
                @foreach($product->variants as $variant)
                    <div class="bg-lilac p-4 rounded-2xl">
                        <span class="font-bold text-ink block mb-0.5">{{ $variant->name }}</span>
                        <span class="text-slate-500">
                            @if(!empty($variant->attributes['description']))
                                {{ $variant->attributes['description'] }}
                            @elseif(!empty($variant->attributes['pieces']))
                                Contains {{ $variant->attributes['pieces'] }} large, durable puzzle pieces.
                            @elseif(!empty($variant->attributes['size']))
                                Format: {{ $variant->attributes['size'] }} cards.
                            @else
                                Price: ₦{{ number_format($variant->price, 2) }}
                            @endif
                        </span>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</section>

<!-- Reviews -->
<section id="reviews-section" class="mt-16 sm:mt-20 scroll-mt-28">
    @php
        $ratingCount = $product->reviews->count();
        $avgScore = $ratingCount > 0 ? round($product->reviews->avg('rating'), 1) : 5.0;
    @endphp
    <div class="flex flex-col md:flex-row items-start md:items-end justify-between gap-5 mb-8">
        <div>
            <h2 class="font-fun font-semibold text-ink text-[28px] sm:text-[36px] leading-tight flex items-center gap-2">Customer Ratings & Reviews</h2>
            <p class="text-[14px] text-slate-500 mt-1">Authentic experiences and comments from verified families and parents.</p>
        </div>
        <button type="button" onclick="toggleReviewForm()" class="bg-ink hover:bg-inkdeep text-white font-bold text-[13px] px-6 h-12 rounded-full transition flex items-center gap-2 flex-shrink-0">
            <i class="bi bi-pencil-square text-sun"></i> <span>Write a Review</span>
        </button>
    </div>

    <div class="grid lg:grid-cols-12 gap-6">
        <div class="lg:col-span-4">
            <div class="bg-white p-6 rounded-[24px] shadow-soft lg:sticky lg:top-28">
                <div class="flex items-center gap-4 mb-5">
                    <div class="font-fun text-[56px] font-semibold text-ink leading-none">{{ number_format($avgScore, 1) }}</div>
                    <div>
                        <div class="flex text-sun text-base gap-0.5">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="bi {{ $i <= round($avgScore) ? 'bi-star-fill' : 'bi-star' }}"></i>
                            @endfor
                        </div>
                        <span class="text-[13px] text-slate-500 font-semibold">Based on {{ $ratingCount }} {{ Str::plural('rating', $ratingCount) }}</span>
                    </div>
                </div>
                <div class="space-y-2 text-[13px]">
                    @for($stars = 5; $stars >= 1; $stars--)
                        @php
                            $starsCount = $product->reviews->where('rating', $stars)->count();
                            $percent = $ratingCount > 0 ? round(($starsCount / $ratingCount) * 100) : ($stars === 5 ? 100 : 0);
                        @endphp
                        <div class="flex items-center gap-3">
                            <span class="w-9 font-bold text-slate-700 flex items-center gap-1">{{ $stars }} <i class="bi bi-star-fill text-sun text-[10px]"></i></span>
                            <div class="flex-1 bg-lilac rounded-full h-2.5 overflow-hidden">
                                <div class="bg-sun h-full rounded-full" style="width: {{ $percent }}%"></div>
                            </div>
                            <span class="w-6 text-right text-slate-400">{{ $starsCount }}</span>
                        </div>
                    @endfor
                </div>
            </div>
        </div>

        <div class="lg:col-span-8 space-y-4">
            <!-- Review Form -->
            <div id="reviewFormContainer" class="hidden bg-white p-6 sm:p-7 rounded-[24px] shadow-lift ring-2 ring-grape/20">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="font-fun font-semibold text-ink text-xl flex items-center gap-2">
                        <i class="bi bi-chat-left-heart-fill text-grape"></i> Share Your Experience
                    </h3>
                    <button type="button" onclick="toggleReviewForm()" class="w-9 h-9 rounded-full hover:bg-lilac text-slate-500 flex items-center justify-center" aria-label="Close">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
                <form action="{{ route('products.reviews.store', $product->id) }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="field-label">Your Rating *</label>
                        <div class="flex items-center gap-1.5" id="starRatingSelector">
                            @for($i = 1; $i <= 5; $i++)
                                <button type="button" onclick="setFormRating({{ $i }})" class="star-rating-btn text-3xl text-slate-300 hover:text-[#FACC15] transition" data-rating="{{ $i }}">
                                    <i class="bi bi-star-fill"></i>
                                </button>
                            @endfor
                            <input type="hidden" name="rating" id="ratingInput" value="5" required>
                            <span id="ratingLabel" class="text-[13px] font-bold text-grape ml-2">5 Stars (Excellent)</span>
                        </div>
                    </div>
                    <div>
                        <label class="field-label">Your Name *</label>
                        <input type="text" name="customer_name" required value="{{ auth()->user()?->name ?? old('customer_name') }}" placeholder="e.g. Mrs. Folake (Lekki)" class="field">
                    </div>
                    <div>
                        <label class="field-label">Customer Review & Comments *</label>
                        <textarea name="comment" rows="4" required placeholder="What did your children think of this product? How was the build quality, learning value, and packaging?" class="field leading-relaxed">{{ old('comment') }}</textarea>
                    </div>
                    <div class="flex items-center justify-end gap-3 pt-1">
                        <button type="button" onclick="toggleReviewForm()" class="px-5 h-11 text-[13px] font-bold text-slate-600 hover:text-ink">Cancel</button>
                        <button type="submit" class="bg-ink hover:bg-inkdeep text-white font-bold text-[13px] px-6 h-11 rounded-full transition">Submit Review</button>
                    </div>
                </form>
            </div>

            @forelse($product->reviews as $review)
                <div class="bg-white p-5 sm:p-6 rounded-[24px] shadow-soft">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-3">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-lilac text-grape font-black text-[12px] flex items-center justify-center flex-shrink-0">
                                {{ strtoupper(substr($review->customer_name, 0, 2)) }}
                            </div>
                            <div>
                                <div class="flex items-center gap-2">
                                    <span class="font-bold text-ink text-[14px]">{{ $review->customer_name }}</span>
                                    <span class="bg-mint text-emerald-800 text-[10px] font-bold px-2 py-0.5 rounded-full uppercase flex items-center gap-1">
                                        <i class="bi bi-patch-check-fill text-emerald-600"></i> Verified
                                    </span>
                                </div>
                                <span class="text-[12px] text-slate-400">{{ $review->created_at ? $review->created_at->diffForHumans() : 'Recent Customer' }}</span>
                            </div>
                        </div>
                        <div class="flex text-sun text-sm gap-0.5">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="bi {{ $i <= $review->rating ? 'bi-star-fill' : 'bi-star' }}"></i>
                            @endfor
                        </div>
                    </div>
                    <p class="text-[14px] text-slate-600 leading-relaxed sm:pl-[52px]">{{ $review->comment }}</p>
                </div>
            @empty
                <div class="text-center py-12 bg-white rounded-[24px] shadow-soft p-6">
                    <div class="w-14 h-14 rounded-2xl bg-lilac text-grape flex items-center justify-center text-2xl mx-auto mb-3"><i class="bi bi-chat-heart"></i></div>
                    <h3 class="font-fun font-semibold text-ink text-lg mb-1">No reviews yet for this product</h3>
                    <p class="text-[13px] text-slate-500 max-w-sm mx-auto mb-5">Be the first parent to share feedback and let other families know about this item!</p>
                    <button type="button" onclick="toggleReviewForm()" class="inline-flex items-center gap-2 bg-ink text-white text-[13px] font-bold px-5 h-11 rounded-full">
                        <i class="bi bi-pencil-square text-sun"></i> Leave the First Review
                    </button>
                </div>
            @endforelse
        </div>
    </div>
</section>

<script>
function handleVariantSelection(input) {
    document.querySelectorAll('.variant-pill-label').forEach(label => {
        label.classList.remove('border-grape');
        label.classList.add('border-transparent');
        const dot = label.querySelector('.variant-indicator span');
        if (dot) dot.classList.add('hidden');
    });

    const activeLabel = input.closest('.variant-pill-label');
    activeLabel.classList.remove('border-transparent');
    activeLabel.classList.add('border-grape');
    const activeDot = activeLabel.querySelector('.variant-indicator span');
    if (activeDot) activeDot.classList.remove('hidden');

    const price = parseFloat(input.getAttribute('data-price')) || 0;
    const stock = parseInt(input.getAttribute('data-stock'), 10);

    const priceDisplay = document.getElementById('priceDisplay');
    priceDisplay.textContent = '₦' + price.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    priceDisplay.setAttribute('data-price-ngn', price);

    const stockDisplay = document.getElementById('stockDisplay');
    const stockBadge = document.getElementById('stockBadge');
    if (stockDisplay && stockBadge) {
        const icon = stockBadge.querySelector('i');
        if (!isNaN(stock) && stock <= 0) {
            stockDisplay.textContent = 'Out of Stock';
            stockBadge.className = 'bg-rose-50 text-rose-800 text-[12px] font-bold px-3 py-1.5 rounded-full flex items-center gap-1.5';
            if (icon) icon.className = 'bi bi-x-circle-fill text-rose-600';
        } else {
            stockDisplay.textContent = 'In Stock';
            stockBadge.className = 'bg-mint text-emerald-800 text-[12px] font-bold px-3 py-1.5 rounded-full flex items-center gap-1.5';
            if (icon) icon.className = 'bi bi-check-circle-fill text-emerald-600';
        }
    }

    const curr = sessionStorage.getItem('selected_currency') || 'NGN';
    if (typeof changeCurrency === 'function') changeCurrency(curr);
}

function toggleReviewForm() {
    const form = document.getElementById('reviewFormContainer');
    form.classList.toggle('hidden');
    if (!form.classList.contains('hidden')) {
        form.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }
}

function setFormRating(rating) {
    document.getElementById('ratingInput').value = rating;
    const labels = {
        1: '1 Star (Needs Improvement)',
        2: '2 Stars (Fair)',
        3: '3 Stars (Good)',
        4: '4 Stars (Very Good)',
        5: '5 Stars (Excellent)'
    };
    document.getElementById('ratingLabel').textContent = labels[rating] || (rating + ' Stars');

    document.querySelectorAll('.star-rating-btn').forEach(btn => {
        const r = parseInt(btn.getAttribute('data-rating'), 10);
        if (r <= rating) {
            btn.classList.remove('text-slate-300');
            btn.classList.add('text-[#FACC15]');
        } else {
            btn.classList.remove('text-[#FACC15]');
            btn.classList.add('text-slate-300');
        }
    });
}

let currentDetailQty = 1;
const maxDetailStock = {{ max(1, $product->stock_quantity) }};

function changeProductDetailQty(delta) {
    const newQty = currentDetailQty + delta;
    if (newQty >= 1 && newQty <= maxDetailStock) {
        currentDetailQty = newQty;
        document.getElementById('productDetailQtyDisplay').textContent = newQty;
        document.getElementById('productDetailQtyInput').value = newQty;
    }
}

function handleProductDetailAddToCart(e) {
    e.preventDefault();
    const btn = document.getElementById('productDetailAddBtn');
    const btnText = document.getElementById('productDetailBtnText');
    const originalText = btnText.textContent;
    btn.disabled = true;
    btnText.innerHTML = '<i class="bi bi-arrow-repeat animate-spin mr-1"></i> Adding...';

    const form = e.target;
    const formData = new FormData(form);

    fetch(form.action, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        btn.disabled = false;
        btnText.innerHTML = '<i class="bi bi-check2-circle text-[#FACC15] mr-1"></i> Added to Box!';
        setTimeout(() => {
            btnText.textContent = originalText;
        }, 1500);

        if (data.success) {
            if (window.updateFloatingCartBar) {
                window.updateFloatingCartBar(data.box, data.subtotal, data.cart_count);
            }
            if (window.renderCartSidebar) {
                window.renderCartSidebar(data);
            }
            showToastNotification(data.message || 'Product added to your box!');
        }
    })
    .catch(err => {
        btn.disabled = false;
        btnText.textContent = originalText;
        console.error(err);
        form.submit();
    });
}

document.addEventListener('DOMContentLoaded', () => {
    setFormRating(5);
});
</script>
@endsection
