@extends('layouts.app')

@section('content')

@php
    $heroPuzzle = $bestsellers->firstWhere('slug', 'give-thanks-psalm-107-jigsaw-puzzle') ?? $puzzles->first();
    $heroColouring = $bestsellers->firstWhere('slug', 'psalm-23-colouring-book') ?? $colouring->first();
    $heroFlashcard = $bestsellers->firstWhere('slug', 'affirmations-flashcards') ?? $flashcards->first();
    $heroStorybook = $bestsellers->firstWhere('slug', 'adventures-of-the-little-explorer') ?? $storybooks->first();
    $heroItems = [
        [$heroPuzzle, '6 & 12 Pieces', 'bg-peach', 'give-thanks-psalm-107-jigsaw-puzzle', 'Give Thanks Puzzle'],
        [$heroColouring, 'Thick Premium Pages', 'bg-blush', 'psalm-23-colouring-book', 'Psalm 23 Colouring'],
        [$heroFlashcard, 'Pocket & Big', 'bg-white', 'affirmations-flashcards', 'Affirmations Cards'],
        [$heroStorybook, 'Written by PD', 'bg-ink', 'adventures-of-the-little-explorer', 'Little Explorer Book'],
    ];
@endphp

<!-- 1. HERO -->
<section class="-mt-2 sm:mt-0">
    <div class="relative rounded-[28px] sm:rounded-[40px] overflow-hidden bg-lilac">
        <div class="grid lg:grid-cols-12 items-stretch">
            <div class="lg:col-span-6 relative z-10 p-6 sm:p-12 lg:p-14 lg:pr-6 flex flex-col justify-center order-2 lg:order-1">
                <span class="inline-flex w-fit items-center gap-2 bg-white text-ink font-bold text-[11px] uppercase tracking-[.14em] px-3.5 py-1.5 rounded-full shadow-soft mb-6">
                    <i class="bi bi-heart-fill text-grape"></i> Faith &amp; Learning for Kids
                </span>
                <h1 class="font-fun text-[34px] sm:text-[50px] lg:text-[56px] font-semibold text-ink leading-[1.05] tracking-tight mb-5">
                    Faith-filled books and activities for growing young minds.
                </h1>
                <p class="text-slate-600 text-[15px] sm:text-[17px] leading-relaxed mb-8 max-w-md">
                    Scripture-inspired jigsaw puzzles, biblical affirmations, illustrated storybooks, and creative colouring books crafted for young disciples.
                </p>
                <div class="flex flex-col sm:flex-row gap-3 mb-6">
                    <a href="#bestsellers" class="h-14 px-7 whitespace-nowrap bg-ink hover:bg-inkdeep text-white font-bold rounded-full flex items-center justify-center gap-2 text-[14px] shadow-lift transition">
                        <i class="bi bi-star-fill text-sun"></i> Shop Bestsellers
                    </a>
                    <a href="#bundles-section" class="h-14 px-7 whitespace-nowrap bg-sun hover:bg-yellow-300 text-ink font-bold rounded-full flex items-center justify-center gap-2 text-[14px] transition">
                        <i class="bi bi-box2-heart-fill"></i> Buy Ready-Made Bundles
                    </a>
                </div>
                <a href="{{ route('catalog.index') }}" class="text-[14px] font-bold text-ink/80 hover:text-grape w-fit mb-8 inline-flex items-center gap-2 group">
                    <span class="underline underline-offset-4 decoration-ink/20 group-hover:decoration-grape">Full Catalogue</span> <i class="bi bi-arrow-right group-hover:translate-x-1 transition"></i>
                </a>
                <div class="flex flex-wrap gap-x-6 gap-y-2 text-[12px] font-semibold text-slate-500">
                    <span class="flex items-center gap-2"><i class="bi bi-shield-check text-emerald-600"></i> 100% Child-Safe &amp; Thick Board</span>
                    <span class="flex items-center gap-2"><i class="bi bi-truck text-amber-500"></i> Lagos (1–2 Days) &amp; Nationwide Delivery</span>
                </div>
            </div>

            <div class="lg:col-span-6 relative order-1 lg:order-2 flex flex-col items-center justify-center px-4 pt-6 pb-2 sm:px-12 sm:pt-12 lg:p-12 lg:pl-4">
                <div class="absolute right-[-60px] top-[-40px] w-[420px] h-[420px] rounded-full bg-sun/50"></div>
                <div class="absolute left-[10%] bottom-[-80px] w-[260px] h-[260px] rounded-full bg-grape/15"></div>
                <span class="absolute right-6 top-3 sm:right-14 sm:top-6 lg:top-10 z-10 bg-ink text-sun text-[12px] font-bold px-3.5 py-1.5 rounded-full rotate-3 shadow-soft">Ages 2 to 9</span>
                <a href="{{ route('catalog.show', $heroPuzzle?->slug ?? 'give-thanks-psalm-107-jigsaw-puzzle') }}" class="relative w-full rotate-[1.5deg] block">
                    <img src="{{ \App\Support\Img::lg('easy_puzzle_1_cover.jpg') }}" alt="Give Thanks (Psalm 107:1) artwork" class="w-full aspect-[3168/2145] object-cover rounded-[20px] sm:rounded-[24px] shadow-lift ring-[5px] sm:ring-[6px] ring-white">
                </a>

                <!-- Featured Physical Products -->
                <div class="relative w-full mt-6 sm:mt-8">
                    <div class="flex items-center justify-between mb-2.5 px-1">
                        <span class="text-[11px] font-bold uppercase tracking-[.14em] text-ink/70 flex items-center gap-1.5"><i class="bi bi-stars text-amber-500"></i> Featured Physical Products</span>
                    </div>
                    <div class="grid grid-cols-4 gap-2 sm:gap-3">
                        @foreach($heroItems as [$item, $tag, $bg, $fallbackSlug, $fallbackName])
                            <a href="{{ route('catalog.show', $item?->slug ?? $fallbackSlug) }}" class="group bg-white rounded-2xl p-1.5 shadow-soft hover:shadow-lift transition">
                                <div class="aspect-square rounded-xl {{ $bg }} flex items-center justify-center p-1.5 overflow-hidden">
                                    <img src="{{ $item?->card_image_url ?? asset('images/products/placeholder.svg') }}" alt="{{ $item?->name ?? $fallbackName }}" class="card-img max-h-full max-w-full object-contain rounded" onerror="this.onerror=null; this.src='{{ asset('images/products/placeholder.svg') }}';">
                                </div>
                                <div class="px-1 pt-1.5 pb-0.5">
                                    <span class="block text-[11px] font-bold text-ink leading-tight line-clamp-1">{{ $item?->name ? \App\Support\ProductTitle::split($item->name)[0] : $fallbackName }}</span>
                                    <span class="hidden sm:block text-[10px] text-slate-500 font-semibold line-clamp-1">{{ $tag }}</span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 2. SHOP BY CATEGORY & AGE -->
<section class="pt-16 sm:pt-24">
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-5 mb-8">
        <div>
            <p class="eyebrow mb-2">Shop by Category &amp; Age</p>
            <h2 class="font-fun font-semibold text-[30px] sm:text-[40px] text-ink leading-tight">Explore by Category</h2>
            <p class="text-[15px] text-slate-500 mt-2">Thoughtfully crafted resources to help children know God and grow in wisdom</p>
        </div>
        <div class="flex gap-2 overflow-x-auto scrollbar-none -mx-4 px-4 md:mx-0 md:px-0">
            <a href="{{ route('catalog.index') }}" class="whitespace-nowrap px-4 h-10 flex items-center rounded-full text-[13px] font-bold bg-ink text-white">All Ages</a>
            <a href="{{ route('catalog.index', ['age' => '2-4']) }}" class="whitespace-nowrap px-4 h-10 flex items-center rounded-full text-[13px] font-bold bg-white border border-ink/10 text-ink hover:border-grape transition">Toddlers (Ages 2–4)</a>
            <a href="{{ route('catalog.index', ['age' => '4-7']) }}" class="whitespace-nowrap px-4 h-10 flex items-center rounded-full text-[13px] font-bold bg-white border border-ink/10 text-ink hover:border-grape transition">Early Learners (Ages 4–7)</a>
            <a href="{{ route('catalog.index', ['age' => '7+']) }}" class="whitespace-nowrap px-4 h-10 flex items-center rounded-full text-[13px] font-bold bg-white border border-ink/10 text-ink hover:border-grape transition">Growing Readers (Ages 7+)</a>
        </div>
    </div>

    @php
        $categoryTiles = [
            ['jigsaw-puzzles', 'Jigsaw Puzzles', 'Ages 2–7 yrs', '6 & 12 Pcs', "Vibrant scripture-inspired puzzles that teach God's Word while developing fine motor and problem-solving skills.", 'Browse Puzzles', 'easy_puzzle_2_cut.jpg', 'bg-peach', true],
            ['colouring-books', 'Colouring Books', 'Ages 3–8 yrs', 'Heavyweight Paper', "Inspiring, premium heavyweight doodle and colouring sheets celebrating God's love, friendship, and joyful worship.", 'Browse Colouring', 'psalm_23_colouring_book_cover.jpg', 'bg-blush', false],
            ['flashcards', 'Flashcards', 'Ages 2–6 yrs', 'Pocket & Big', 'Daily biblical affirmations and vocabulary cards in Pocket and Big sizes to build identity in Christ.', 'Browse Flashcards', 'affirmations_flashcards_cover.jpg', 'bg-lilac', false],
            ['storybooks', 'Storybooks', 'Ages 3–9 yrs', 'Illustrated', 'Illustrated bedtime stories by PD designed to cultivate godly character, empathy, and courage.', 'Browse Storybooks', 'story_little_explorer.svg', 'bg-ink', false],
        ];
    @endphp
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-5">
        @foreach($categoryTiles as [$slug, $name, $age, $tag, $desc, $cta, $img, $bg, $cover])
            <a href="{{ route('catalog.index', ['category' => $slug]) }}" class="group block">
                <div class="aspect-[4/5] rounded-[24px] overflow-hidden {{ $bg }} relative {{ $cover ? '' : 'flex items-center justify-center p-6' }}">
                    <img src="{{ str_ends_with($img, '.jpg') ? \App\Support\Img::sm($img) : asset('images/products/' . $img) }}" alt="{{ $name }}" loading="lazy" class="card-img {{ $cover ? 'absolute inset-0 w-full h-full object-cover' : 'w-full h-full object-contain drop-shadow-xl' }}">
                    <div class="absolute left-3 top-3 flex flex-wrap gap-1.5">
                        <span class="bg-white/95 text-ink text-[11px] font-bold px-2.5 py-1 rounded-full">{{ $age }}</span>
                        <span class="hidden sm:inline bg-sun text-ink text-[11px] font-bold px-2.5 py-1 rounded-full">{{ $tag }}</span>
                    </div>
                </div>
                <div class="pt-4 px-1">
                    <div class="flex items-center justify-between gap-2">
                        <h3 class="font-fun font-semibold text-ink text-[18px] sm:text-[20px] leading-tight">{{ $name }}</h3>
                        <span class="w-9 h-9 rounded-full bg-lilac text-ink flex items-center justify-center group-hover:bg-ink group-hover:text-sun transition flex-shrink-0" aria-hidden="true"><i class="bi bi-arrow-up-right"></i></span>
                    </div>
                    <p class="hidden sm:block text-[13px] text-slate-500 leading-relaxed mt-1">{{ $desc }}</p>
                    <span class="sr-only">{{ $cta }}</span>
                </div>
            </a>
        @endforeach
    </div>
</section>

<!-- 3. HOW SHOPPING WORKS -->
<section class="pt-16 sm:pt-24">
    <div class="text-center mb-8">
        <p class="eyebrow mb-2">How Shopping Works</p>
        <h2 class="font-fun font-semibold text-[28px] sm:text-[36px] text-ink leading-tight">Two Simple Ways to Order at 800BYPD</h2>
    </div>
    <div class="grid md:grid-cols-2 gap-4 sm:gap-5">
        <div class="rounded-[28px] bg-lilac overflow-hidden grid grid-cols-1 sm:grid-cols-5">
            <div class="sm:col-span-3 p-6 sm:p-8 flex flex-col order-2 sm:order-1">
                <span class="font-fun text-[44px] leading-none font-semibold text-grape/30 mb-3">01</span>
                <h3 class="font-fun font-semibold text-ink text-[22px] leading-tight mb-2">Option 1: Build Your Own Custom Box</h3>
                <p class="text-[14px] text-slate-600 leading-relaxed mb-6">Select any <strong>3 or more items</strong> across puzzles, flashcards, storybooks, and colouring books to fulfill the minimum checkout requirement. Mix and match freely!</p>
                <a href="{{ route('catalog.index') }}" class="mt-auto h-12 px-6 bg-ink hover:bg-inkdeep text-white rounded-full font-bold text-[13px] w-fit flex items-center gap-2 transition">Start Custom Box <i class="bi bi-arrow-right"></i></a>
            </div>
            <div class="sm:col-span-2 relative h-48 sm:h-auto order-1 sm:order-2">
                <img src="{{ \App\Support\Img::sm('intermediate_puzzle_1_cut.jpg') }}" alt="" loading="lazy" class="absolute inset-0 w-full h-full object-cover object-[center_85%]">
            </div>
        </div>
        <div class="rounded-[28px] bg-peach overflow-hidden grid grid-cols-1 sm:grid-cols-5">
            <div class="sm:col-span-3 p-6 sm:p-8 flex flex-col order-2 sm:order-1">
                <span class="font-fun text-[44px] leading-none font-semibold text-amber-500/40 mb-3">02</span>
                <h3 class="font-fun font-semibold text-ink text-[22px] leading-tight mb-2">Option 2: Pick a Ready-Made Bundle</h3>
                <p class="text-[14px] text-slate-600 leading-relaxed mb-6">Want an all-in-one package without counting items? Grab our <strong>Starter (5 items)</strong> or <strong>Explorer (10 items)</strong> bundle for instant 1-click checkout.</p>
                <a href="#bundles-section" class="mt-auto h-12 px-6 bg-sun hover:bg-yellow-300 text-ink rounded-full font-bold text-[13px] w-fit flex items-center gap-2 transition">See Ready-Made Bundles <i class="bi bi-arrow-right"></i></a>
            </div>
            <div class="sm:col-span-2 relative h-56 sm:h-auto bg-amber-100 flex items-center justify-center order-1 sm:order-2 overflow-hidden">
                <div class="relative w-[80%] sm:w-[88%] h-[80%] max-w-[260px]">
                    <img src="{{ \App\Support\Img::sm('light_series_colouring_book_cover.jpg') }}" alt="" loading="lazy" class="absolute left-0 top-2 w-[46%] sm:w-[60%] rounded-xl shadow-lift -rotate-6">
                    <img src="{{ \App\Support\Img::sm('affirmations_flashcards_cover.jpg') }}" alt="" loading="lazy" class="absolute right-0 top-6 w-[44%] sm:w-[56%] rounded-xl shadow-lift rotate-6">
                    <img src="{{ \App\Support\Img::sm('easy_puzzle_3_cut.jpg') }}" alt="" loading="lazy" class="absolute left-[14%] bottom-0 w-[72%] rounded-xl shadow-lift -rotate-2">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 4. CURATED BESTSELLERS -->
<section id="bestsellers" class="pt-16 sm:pt-24 scroll-mt-28">
    <div class="flex items-end justify-between gap-4 mb-8">
        <div>
            <p class="eyebrow mb-2 flex items-center gap-2"><i class="bi bi-trophy-fill text-amber-500"></i> Parent Favourites</p>
            <h2 class="font-fun font-semibold text-[30px] sm:text-[40px] text-ink leading-tight">Curated Bestsellers</h2>
            <p class="text-[15px] text-slate-500 mt-2">Our most loved physical products for family devotions and active learning</p>
        </div>
        <a href="{{ route('catalog.index') }}" class="hidden sm:flex h-11 px-5 rounded-full border border-ink/15 text-ink font-bold text-[13px] items-center gap-2 hover:bg-ink hover:text-white transition whitespace-nowrap">Explore All 14+ Items <i class="bi bi-arrow-right"></i></a>
    </div>

    <div class="flex lg:grid lg:grid-cols-4 gap-4 sm:gap-5 overflow-x-auto scrollbar-none snap-x snap-mandatory -mx-4 px-4 lg:mx-0 lg:px-0 pb-3">
        @foreach($bestsellers as $product)
            @include('storefront.partials.product-card', ['product' => $product, 'class' => 'snap-start min-w-[78%] sm:min-w-[46%] lg:min-w-0'])
        @endforeach
    </div>
    <a href="{{ route('catalog.index') }}" class="sm:hidden mt-4 h-12 rounded-full border border-ink/15 text-ink font-bold text-[13px] flex items-center justify-center gap-2">Explore All 14+ Items <i class="bi bi-arrow-right"></i></a>
</section>

<!-- 5. MORE PUZZLES STRIP -->
@if($puzzles->isNotEmpty())
<section class="pt-16 sm:pt-24">
    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-6">
        <div>
            <h2 class="font-fun font-semibold text-[24px] sm:text-[32px] text-ink leading-tight">Looking for more puzzles, flashcards, or colouring books?</h2>
            <p class="text-[14px] text-slate-500 mt-2">We have 14+ faith-anchored educational titles ready to ship nationwide.</p>
        </div>
        <a href="{{ route('catalog.index') }}" class="h-12 px-6 bg-grape hover:bg-purple-800 text-white font-bold text-[13px] rounded-full w-fit flex items-center gap-2 transition whitespace-nowrap flex-shrink-0">Browse Full Catalogue <i class="bi bi-arrow-right"></i></a>
    </div>
    <div class="flex gap-4 overflow-x-auto scrollbar-none snap-x -mx-4 px-4 sm:-mx-8 sm:px-8 pb-2">
        @foreach($puzzles as $puzzle)
            @php
                [$pTitle, $pRef] = \App\Support\ProductTitle::split($puzzle->name);
            @endphp
            <a href="{{ route('catalog.show', $puzzle->slug) }}" class="snap-start shrink-0 w-[80vw] sm:w-[400px] group">
                <div class="aspect-[3/2] rounded-[24px] overflow-hidden bg-peach">
                    <img src="{{ $puzzle->card_image_url }}" alt="{{ $puzzle->name }}" loading="lazy" class="card-img w-full h-full object-cover" onerror="this.onerror=null; this.src='{{ asset('images/products/placeholder.svg') }}';">
                </div>
                <div class="mt-3 flex items-start justify-between gap-3 px-1">
                    <div>
                        <p class="font-fun font-semibold text-ink text-[17px] leading-snug group-hover:text-grape transition">{{ $pTitle }}</p>
                        @if($pRef)<p class="text-[12px] font-bold text-grape">{{ $pRef }}</p>@endif
                    </div>
                    <span class="text-[15px] font-extrabold text-ink price-convertible whitespace-nowrap" data-price-ngn="{{ $puzzle->sale_price ?? $puzzle->price }}">{{ $puzzle->formatted_price }}</span>
                </div>
            </a>
        @endforeach
    </div>
</section>
@endif

<!-- 6. READY-MADE BUNDLES -->
<section id="bundles-section" class="pt-16 sm:pt-24 scroll-mt-28">
    <div class="relative rounded-[28px] sm:rounded-[40px] bg-ink text-white overflow-hidden p-5 sm:p-12">
        <div class="absolute inset-0 dots-bg opacity-[.12] pointer-events-none"></div>
        <div class="relative flex flex-col lg:flex-row lg:items-end justify-between gap-5 mb-8 sm:mb-10">
            <div class="max-w-xl">
                <p class="text-sun font-bold text-[12px] uppercase tracking-[.16em] mb-2">Curated Value Packages</p>
                <h2 class="font-fun font-semibold text-[32px] sm:text-[44px] leading-tight">Ready-Made Bundles</h2>
                <p class="text-indigo-200 text-[15px] mt-2 leading-relaxed">Thoughtfully combined collections for families and classrooms. Instantly fulfills your box order for seamless 1-click checkout.</p>
            </div>
            <a href="{{ route('bundles.index') }}" class="h-12 px-6 bg-white/10 hover:bg-white/20 border border-white/20 text-white font-bold text-[13px] rounded-full w-fit flex items-center gap-2 whitespace-nowrap transition">View Dedicated Bundles Page <i class="bi bi-arrow-right"></i></a>
        </div>

        <div id="bundlesCarousel" class="relative flex lg:grid lg:grid-cols-2 gap-4 sm:gap-5 overflow-x-auto lg:overflow-visible snap-x snap-mandatory scrollbar-none -mx-5 px-5 sm:mx-0 sm:px-0 pb-1">
            @forelse($bundles as $index => $bundle)
                @include('storefront.partials.bundle-card', ['bundle' => $bundle, 'index' => $index, 'formHandler' => 'handleHomepageAddBundle', 'buttonLabel' => 'Add to Cart', 'compact' => true])
            @empty
                <div class="col-span-full py-8 text-center text-indigo-200">
                    <p class="font-bold text-sm">Bundles are currently being configured.</p>
                </div>
            @endforelse
        </div>

        <div class="relative flex lg:hidden items-center justify-between mt-5 text-[12px] font-semibold text-indigo-200">
            <span class="flex items-center gap-1.5"><i class="bi bi-arrow-left-right text-sun"></i> Swipe to compare bundles</span>
            <div id="bundleCarouselDots" class="flex items-center gap-2">
                @foreach($bundles as $index => $bundle)
                    <button type="button" onclick="scrollBundleCarousel({{ $index }})" aria-label="Go to bundle {{ $index + 1 }}" class="bundle-dot transition-all duration-300 rounded-full cursor-pointer {{ $index === 0 ? 'w-6 h-2.5 bg-[#FACC15]' : 'w-2.5 h-2.5 bg-indigo-300/40 hover:bg-indigo-200' }}"></button>
                @endforeach
            </div>
        </div>
    </div>
</section>

<!-- 7. PARENT TESTIMONIALS -->
<section class="pt-16 sm:pt-24">
    <div class="grid lg:grid-cols-12 gap-8 lg:gap-10 items-start">
        <div class="lg:col-span-4 lg:sticky lg:top-28">
            <p class="eyebrow mb-2">Parent Testimonials</p>
            <h2 class="font-fun font-semibold text-[30px] sm:text-[40px] text-ink leading-tight mb-4">Loved by Families Across Nigeria</h2>
            <div class="flex items-center gap-3">
                <div class="font-fun text-[48px] font-semibold text-ink leading-none">4.9</div>
                <div>
                    <div class="flex text-amber-400 text-sm gap-0.5"><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i></div>
                    <div class="text-[12px] font-bold text-slate-500 mt-1">4.9 / 5.0 (Verified Purchases)</div>
                </div>
            </div>
        </div>
        @php
            $testimonials = [
                ['"The Give Thanks puzzle has become our morning devotion routine. The pieces are thick, durable, and don\'t bend when my 3-year-old handles them. Seeing her memorize Psalm 107:1 while playing is pure joy!"', 'CO', 'Chidinma O.', 'Lekki, Lagos', 'bg-lilac text-grape'],
                ['"We speak the Affirmations Flashcards together in the car on the school run every morning. It has built so much godly confidence in my son. Delivered to Abuja within 3 days without a scratch."', 'EK', 'Pastor Emmanuel K.', 'Abuja FCT', 'bg-indigo-100 text-indigo-700'],
                ['"The Psalm 23 Colouring Book paper quality is exceptional! My twins used both crayons and washable markers, and the heavyweight pages held up with zero seep-through. The Starter Bundle made checkout effortless."', 'GA', 'Grace A.', 'Ikeja, Lagos', 'bg-pink-100 text-pink-700'],
            ];
        @endphp
        <div class="lg:col-span-8 flex lg:grid lg:grid-cols-2 gap-4 overflow-x-auto lg:overflow-visible scrollbar-none snap-x snap-mandatory -mx-4 px-4 lg:mx-0 lg:px-0 pb-2 lg:pb-10">
            @foreach($testimonials as $i => [$quote, $initials, $name, $place, $avatar])
                <figure class="snap-start shrink-0 w-[85%] sm:w-[60%] lg:w-auto bg-white rounded-[24px] p-6 sm:p-7 shadow-soft {{ $i === 1 ? 'lg:translate-y-10' : '' }}">
                    <i class="bi bi-quote text-[40px] leading-none text-sun"></i>
                    <blockquote class="text-[15px] text-slate-700 leading-relaxed mt-2 mb-6">{{ $quote }}</blockquote>
                    <figcaption class="flex items-center gap-3">
                        <span class="w-10 h-10 rounded-full {{ $avatar }} font-black text-[12px] flex items-center justify-center">{{ $initials }}</span>
                        <span>
                            <span class="block text-[14px] font-bold text-ink">{{ $name }}</span>
                            <span class="text-[12px] text-emerald-600 font-semibold"><i class="bi bi-patch-check-fill"></i> Verified Buyer • {{ $place }}</span>
                        </span>
                    </figcaption>
                </figure>
            @endforeach
            <div class="hidden lg:block rounded-[24px] overflow-hidden lg:translate-y-10 min-h-[240px]">
                <img src="{{ \App\Support\Img::sm('easy_puzzle_3_cut.jpg') }}" alt="" loading="lazy" class="w-full h-full object-cover">
            </div>
        </div>
    </div>
</section>

<!-- 8. MEET THE CREATOR -->
<section class="pt-16 sm:pt-24">
    <div class="grid lg:grid-cols-2 rounded-[28px] sm:rounded-[40px] overflow-hidden bg-peach">
        <div class="relative min-h-[300px] lg:min-h-[480px] bg-ink">
            <img src="{{ \App\Support\Img::lg('easy_puzzle_3_cover.jpg') }}" alt="Kiki, her brother and puppy from 800BYPD's illustrated world" loading="lazy" class="absolute inset-0 w-full h-full object-cover object-[center_75%]">
            <div class="absolute left-5 bottom-5 bg-white/95 rounded-2xl pl-2 pr-4 py-2 shadow-lift flex items-center gap-3">
                <span class="w-12 h-12 rounded-xl bg-ink text-sun flex items-center justify-center font-fun font-bold text-xl rotate-2">PD</span>
                <span>
                    <span class="block font-fun text-ink text-[17px] font-semibold leading-tight">Pelumi Dada (PD)</span>
                    <span class="text-[12px] text-slate-500 font-semibold">WrittenbyPD · Founder &amp; Author</span>
                </span>
            </div>
        </div>
        <div class="p-6 sm:p-12 lg:p-14 flex flex-col justify-center">
            <p class="eyebrow mb-2">Behind the Brand</p>
            <h2 class="font-fun font-semibold text-[30px] sm:text-[40px] text-ink leading-tight mb-5">A Mission to Anchor Young Hearts in Faith</h2>
            <p class="text-[15px] sm:text-[16px] text-slate-700 leading-relaxed mb-6">"As an author and educator, I created <strong>800BYPD</strong> out of a desire to make God’s Word accessible, engaging, and memorable for children. From bedtime storybooks to hands-on scripture puzzles and affirmation flashcards, every item is prayerfully designed to help parents raise confident, joyful, and faith-filled children."</p>
            <p class="font-bold text-ink mb-7">Pelumi Dada (PD), Founder &amp; Author</p>
            <a href="https://wa.me/2348164254442?text=Hello%20PD!%20I%20have%20a%20question%20about%20your%20products." target="_blank" class="h-12 px-6 bg-[#25D366] hover:bg-emerald-600 text-white font-bold text-[13px] rounded-full w-fit flex items-center gap-2 transition">
                <i class="bi bi-whatsapp"></i> Chat with PD on WhatsApp
            </a>
        </div>
    </div>
</section>

<!-- 9. AUDIO + DELIVERY -->
<section class="pt-16 sm:pt-24">
    <div class="grid lg:grid-cols-12 gap-4 sm:gap-5">
        <div class="lg:col-span-5 rounded-[28px] bg-inkdeep text-white p-6 sm:p-9 relative overflow-hidden flex flex-col">
            <div class="absolute -right-10 -bottom-10 w-56 h-56 rounded-full bg-grape/40 blur-2xl"></div>
            <div class="relative flex items-center gap-3 mb-5">
                <div class="w-12 h-12 rounded-2xl bg-[#1DB954] flex items-center justify-center text-2xl flex-shrink-0"><i class="bi bi-spotify"></i></div>
                <p class="text-sun font-bold text-[11px] uppercase tracking-[.16em]">Audio Companion Stream</p>
            </div>
            <h3 class="relative font-fun font-semibold text-[24px] sm:text-[26px] leading-tight mb-3">Affirmations, Bedtime Faith Stories &amp; Scripture Audio</h3>
            <p class="relative text-[14px] text-indigo-200 mb-6">Listen to "The Steadfast Love of God" &amp; "Starry Night Journey" narrated by PD.</p>
            <div class="relative mb-6">
                <x-spotify-player height="152" />
            </div>
            <a href="{{ route('audios.index') }}" class="relative mt-auto h-12 px-6 bg-[#1DB954] hover:bg-emerald-600 text-white font-bold text-[13px] rounded-full w-fit flex items-center gap-2 transition"><i class="bi bi-play-circle-fill"></i> Listen on Spotify</a>
        </div>

        <div class="lg:col-span-7 rounded-[28px] bg-white shadow-soft p-6 sm:p-9">
            <p class="eyebrow mb-2">Shipping &amp; Support</p>
            <h3 class="font-fun font-semibold text-[26px] sm:text-[30px] text-ink leading-tight mb-7">Fast, Safe &amp; Dependable Delivery</h3>
            <div class="grid sm:grid-cols-2 gap-x-8 gap-y-6">
                <div class="flex gap-4"><span class="w-12 h-12 shrink-0 rounded-2xl bg-lilac text-grape flex items-center justify-center text-xl"><i class="bi bi-truck"></i></span><div><h4 class="font-bold text-ink text-[15px]">Lagos Express</h4><p class="text-[13px] text-slate-500 leading-relaxed">1–2 business days flat delivery across all Lagos locations.</p></div></div>
                <div class="flex gap-4"><span class="w-12 h-12 shrink-0 rounded-2xl bg-peach text-amber-700 flex items-center justify-center text-xl"><i class="bi bi-geo-alt-fill"></i></span><div><h4 class="font-bold text-ink text-[15px]">All 36 States</h4><p class="text-[13px] text-slate-500 leading-relaxed">3–5 business days nationwide delivery via dependable tracked courier.</p></div></div>
                <div class="flex gap-4"><span class="w-12 h-12 shrink-0 rounded-2xl bg-mint text-emerald-700 flex items-center justify-center text-xl"><i class="bi bi-patch-check-fill"></i></span><div><h4 class="font-bold text-ink text-[15px]">Quality Assured</h4><p class="text-[13px] text-slate-500 leading-relaxed">Carefully inspected and securely packaged to arrive at your door in pristine condition.</p></div></div>
                <div class="flex gap-4"><span class="w-12 h-12 shrink-0 rounded-2xl bg-blue-50 text-blue-700 flex items-center justify-center text-xl"><i class="bi bi-lock-fill"></i></span><div><h4 class="font-bold text-ink text-[15px]">Secure Payments</h4><p class="text-[13px] text-slate-500 leading-relaxed">Encrypted checkout via Paystack with Cards, Bank Transfer, &amp; USSD.</p></div></div>
            </div>
        </div>
    </div>
</section>

<script>
function handleHomepageAddBundle(e) {
    e.preventDefault();
    const form = e.target;
    const btn = form.querySelector('button[type="submit"]');
    const originalHtml = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = '<i class="bi bi-arrow-repeat animate-spin mr-1"></i> Adding...';

    fetch(form.action, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ quantity: 1 })
    })
    .then(res => res.json())
    .then(data => {
        btn.disabled = false;
        btn.innerHTML = '<i class="bi bi-check2-circle text-[#FACC15] mr-1"></i> Added!';
        setTimeout(() => { btn.innerHTML = originalHtml; }, 2000);
        if (data.success) {
            if (window.updateFloatingCartBar) {
                window.updateFloatingCartBar(data.box, data.subtotal, data.cart_count);
            }
            if (window.renderCartSidebar) {
                window.renderCartSidebar(data);
            }
            showToastNotification(data.message || 'Bundle added to your box!');
        }
    })
    .catch(err => {
        btn.disabled = false;
        btn.innerHTML = originalHtml;
        console.error(err);
        form.submit();
    });
}

function scrollBundleCarousel(index) {
    const carousel = document.getElementById('bundlesCarousel');
    if (!carousel) return;
    const cards = carousel.querySelectorAll('[data-bundle-index]');
    if (cards[index]) {
        cards[index].scrollIntoView({ behavior: 'smooth', inline: 'center', block: 'nearest' });
    }
}

function updateBundleCarouselDots() {
    const carousel = document.getElementById('bundlesCarousel');
    const dots = document.querySelectorAll('#bundleCarouselDots .bundle-dot');
    if (!carousel || dots.length === 0) return;

    const cards = carousel.querySelectorAll('[data-bundle-index]');
    if (cards.length === 0) return;

    const carouselRect = carousel.getBoundingClientRect();
    const carouselCenter = carouselRect.left + carouselRect.width / 2;

    let closestDist = Infinity;
    let activeIndex = 0;

    cards.forEach((card, idx) => {
        const rect = card.getBoundingClientRect();
        const cardCenter = rect.left + rect.width / 2;
        const dist = Math.abs(carouselCenter - cardCenter);
        if (dist < closestDist) {
            closestDist = dist;
            activeIndex = idx;
        }
    });

    dots.forEach((dot, idx) => {
        if (idx === activeIndex) {
            dot.className = 'bundle-dot transition-all duration-300 rounded-full cursor-pointer w-6 h-2.5 bg-[#FACC15]';
        } else {
            dot.className = 'bundle-dot transition-all duration-300 rounded-full cursor-pointer w-2.5 h-2.5 bg-indigo-300/40 hover:bg-indigo-200';
        }
    });
}

document.addEventListener('DOMContentLoaded', () => {
    const carousel = document.getElementById('bundlesCarousel');
    if (carousel) {
        carousel.addEventListener('scroll', () => {
            requestAnimationFrame(updateBundleCarouselDots);
        }, { passive: true });
        updateBundleCarouselDots();
    }
});
</script>
@endsection
