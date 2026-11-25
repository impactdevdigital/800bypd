@extends('layouts.app')

@section('content')
@php
    $keep = fn (array $extra) => array_filter(array_merge(['age' => request('age'), 'category' => request('category'), 'search' => request('search'), 'sort' => request('sort')], $extra));
    $activeCat = request('category');
    $catPills = [
        ['jigsaw-puzzles', 'Jigsaw Puzzles', 'Easy & 12-pc', 'easy_puzzle_2_cut.jpg', 'bg-peach', true],
        ['colouring-books', 'Colouring Books', null, 'psalm_23_colouring_book_cover.jpg', 'bg-blush', false],
        ['flashcards', 'Flashcards', 'Pocket & Big', 'affirmations_flashcards_cover.jpg', 'bg-lilac', false],
        ['storybooks', 'Storybooks', null, 'story_little_explorer.svg', 'bg-ink', false],
    ];
    $agePills = [
        ['', 'All Ages'],
        ['2-4', 'Ages 2–4 yrs (Toddlers)'],
        ['4-7', 'Ages 4–7 yrs (Early Learners)'],
        ['7+', 'Ages 7+ yrs (Growing Readers)'],
    ];
@endphp

<!-- Catalog Header -->
<section class="relative rounded-[28px] sm:rounded-[36px] bg-lilac overflow-hidden mb-8">
    <div class="absolute -right-24 -top-24 w-80 h-80 rounded-full bg-sun/40"></div>
    <div class="relative p-6 sm:p-10 flex flex-col md:flex-row justify-between md:items-end gap-5">
        <div>
            <span class="inline-flex items-center gap-2 bg-white text-ink font-bold text-[11px] uppercase tracking-[.14em] px-3.5 py-1.5 rounded-full shadow-soft mb-4">
                <i class="bi bi-box-seam-fill text-grape"></i> Fill Your Box Store
            </span>
            <h1 class="font-fun text-[34px] sm:text-[48px] font-semibold text-ink leading-tight">Product Catalog</h1>
            <p class="text-[15px] text-slate-600 mt-1">Explore our 4 faith-nurturing collections & curated bundles in <span class="currency-name font-bold text-ink">Naira (₦)</span></p>
        </div>
        <div class="flex items-center gap-2 w-full md:w-auto">
            <a href="{{ route('bundles.index') }}" class="flex-1 md:flex-none h-12 px-5 inline-flex items-center justify-center gap-2 bg-sun hover:bg-yellow-300 text-ink text-[13px] font-bold rounded-full transition">
                <i class="bi bi-box2-heart-fill"></i> View Bundles
            </a>
            <button onclick="toggleMobileFilters()" class="lg:hidden flex-1 md:flex-none h-12 px-5 bg-white text-ink font-bold text-[13px] rounded-full flex items-center justify-center gap-2 shadow-soft transition">
                <i class="bi bi-funnel-fill text-grape"></i> Filters
            </button>
        </div>
    </div>
</section>

<!-- Category Quick Pills -->
<div class="mb-4 overflow-x-auto scrollbar-none -mx-4 px-4 sm:mx-0 sm:px-0 pb-1">
    <div class="flex items-center gap-2.5 min-w-max">
        <a href="{{ route('catalog.index', $keep(['category' => null])) }}"
           class="h-12 pl-4 pr-5 rounded-full text-[13px] font-bold transition flex items-center gap-2 {{ !$activeCat ? 'bg-ink text-white' : 'bg-white text-ink shadow-soft hover:bg-lilac' }}">
            <i class="bi bi-grid-fill {{ !$activeCat ? 'text-sun' : 'text-grape' }}"></i> All Categories
        </a>
        @foreach($catPills as [$slug, $label, $tag, $img, $bg, $cover])
            @continue(! \App\Models\Category::isSlugActive($slug))
            @php $isActive = $activeCat === $slug || ($slug === 'colouring-books' && $activeCat === 'coloring-books'); @endphp
            <a href="{{ route('catalog.index', $keep(['category' => $slug])) }}"
               class="h-12 pl-1.5 pr-5 rounded-full text-[13px] font-bold transition flex items-center gap-2.5 {{ $isActive ? 'bg-ink text-white' : 'bg-white text-ink shadow-soft hover:bg-lilac' }}">
                <span class="w-9 h-9 rounded-full overflow-hidden {{ $bg }} flex items-center justify-center flex-shrink-0">
                    <img src="{{ str_ends_with($img, '.jpg') ? \App\Support\Img::sm($img) : asset('images/products/' . $img) }}" alt="" class="{{ $cover ? 'w-full h-full object-cover' : 'h-7 object-contain' }}">
                </span>
                {{ $label }}
                @if($tag)
                    <span class="text-[10px] px-2 py-0.5 rounded-full font-bold {{ $isActive ? 'bg-white/15 text-sun' : 'bg-lilac text-grape' }}">{{ $tag }}</span>
                @endif
            </a>
        @endforeach
        <a href="{{ route('bundles.index') }}" class="h-12 px-5 rounded-full text-[13px] font-bold transition flex items-center gap-2 bg-peach text-ink hover:bg-amber-100">
            <i class="bi bi-gift-fill text-amber-500"></i> Pre-defined Bundles
            <span class="text-[10px] bg-ink text-sun px-2 py-0.5 rounded-full font-bold">Curated</span>
        </a>
    </div>
</div>

<!-- Age Quick Pills -->
<div class="mb-8 overflow-x-auto scrollbar-none -mx-4 px-4 sm:mx-0 sm:px-0 flex items-center gap-2">
    <span class="text-[12px] font-bold text-slate-400 uppercase tracking-wider flex items-center gap-1.5 mr-1 whitespace-nowrap">
        <i class="bi bi-person-heart text-grape"></i> Shop by Age:
    </span>
    @foreach($agePills as [$age, $label])
        @php $isAge = (string) request('age') === $age; @endphp
        <a href="{{ route('catalog.index', $keep(['age' => $age ?: null])) }}"
           class="whitespace-nowrap px-4 h-9 flex items-center rounded-full text-[12px] font-bold transition {{ $isAge ? 'bg-grape text-white' : 'bg-white border border-ink/10 text-slate-600 hover:border-grape' }}">
            {{ $label }}
        </a>
    @endforeach
</div>

<div class="grid grid-cols-1 lg:grid-cols-4 gap-6 sm:gap-8">
    <!-- Sidebar Filters -->
    <aside id="catalogFiltersSidebar" class="hidden lg:block h-fit lg:sticky lg:top-28 space-y-4">
        <div class="bg-white p-6 rounded-[24px] shadow-soft">
            <div class="flex items-center justify-between mb-5">
                <h3 class="font-fun font-semibold text-ink text-lg flex items-center gap-2">
                    <i class="bi bi-sliders text-grape"></i> <span>Filters</span>
                </h3>
                <a href="{{ route('catalog.index') }}" class="text-[12px] text-grape font-bold hover:underline flex items-center gap-1">
                    <i class="bi bi-arrow-counterclockwise"></i> Reset
                </a>
            </div>

            <form action="{{ route('catalog.index') }}" method="GET" class="space-y-6">
                <div>
                    <label class="field-label">Search Products</label>
                    <div class="relative">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Puzzles, flashcards, stories..." class="field !pl-10 !py-2.5 !text-[13px]">
                        <i class="bi bi-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    </div>
                </div>

                <div>
                    <label class="field-label">Product Categories</label>
                    <div class="space-y-1 text-[13px]">
                        <label class="flex items-center gap-2.5 px-3 py-2 rounded-xl cursor-pointer hover:bg-lilac transition {{ !request('category') ? 'bg-lilac font-bold text-grape' : 'text-slate-600' }}">
                            <input type="radio" name="category" value="" {{ !request('category') ? 'checked' : '' }} onchange="this.form.submit()" class="accent-[#7C3AED]">
                            <span><i class="bi bi-grid-fill text-slate-400 mr-1"></i> All Categories</span>
                        </label>
                        @foreach($categories as $cat)
                            <label class="flex items-center gap-2.5 px-3 py-2 rounded-xl cursor-pointer hover:bg-lilac transition {{ request('category') == $cat->slug ? 'bg-lilac font-bold text-grape' : 'text-slate-600' }}">
                                <input type="radio" name="category" value="{{ $cat->slug }}" {{ request('category') == $cat->slug ? 'checked' : '' }} onchange="this.form.submit()" class="accent-[#7C3AED]">
                                <span>
                                    @if($cat->slug === 'jigsaw-puzzles')
                                        <i class="bi bi-puzzle-fill text-amber-500 mr-1"></i>
                                    @elseif(in_array($cat->slug, ['colouring-books', 'coloring-books']))
                                        <i class="bi bi-palette-fill text-pink-500 mr-1"></i>
                                    @elseif($cat->slug === 'flashcards')
                                        <i class="bi bi-card-text text-indigo-500 mr-1"></i>
                                    @elseif($cat->slug === 'storybooks')
                                        <i class="bi bi-book-half text-emerald-500 mr-1"></i>
                                    @else
                                        <i class="bi bi-tag-fill text-purple-400 mr-1"></i>
                                    @endif
                                    {{ $cat->name }}
                                </span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div>
                    <label class="field-label">Age Group</label>
                    <div class="space-y-1 text-[13px]">
                        @foreach($agePills as [$age, $label])
                            @php $isAge = (string) request('age') === $age; @endphp
                            <label class="flex items-center gap-2.5 px-3 py-2 rounded-xl cursor-pointer hover:bg-lilac transition {{ $isAge ? 'bg-lilac font-bold text-grape' : 'text-slate-600' }}">
                                <input type="radio" name="age" value="{{ $age }}" {{ $isAge ? 'checked' : '' }} onchange="this.form.submit()" class="accent-[#7C3AED]">
                                <span>{{ $label }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div>
                    <label class="field-label">Sort By</label>
                    <select name="sort" onchange="this.form.submit()" class="field !py-2.5 !text-[13px]">
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest Arrivals</option>
                        <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                        <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                        <option value="bestsellers" {{ request('sort') == 'bestsellers' ? 'selected' : '' }}>Featured / Bestsellers</option>
                    </select>
                </div>

                <button type="submit" class="w-full bg-ink hover:bg-inkdeep text-white font-bold text-[13px] h-12 rounded-full transition flex items-center justify-center gap-1.5">
                    <i class="bi bi-check-lg text-sun"></i> Apply Filters
                </button>
            </form>
        </div>

        <!-- Fill Your Box Tip -->
        <div class="p-5 rounded-[24px] bg-peach">
            <div class="flex items-center gap-2 font-bold mb-1.5 text-ink text-[14px]">
                <i class="bi bi-box-seam-fill text-grape"></i> Fill Your Box Tip
            </div>
            <p class="text-[13px] text-slate-600 leading-relaxed">
                Add at least <strong class="text-ink">{{ \App\Models\Setting::get('checkout_min_order_quantity', 3) }} items</strong> to unlock checkout. Bundles count as multiple items towards your box!
            </p>
        </div>
    </aside>

    <!-- Product Grid -->
    <div class="lg:col-span-3">
        <div class="grid grid-cols-1 min-[480px]:grid-cols-2 xl:grid-cols-3 gap-4 sm:gap-5">
            @forelse($products as $product)
                @include('storefront.partials.product-card', ['product' => $product])
            @empty
                <div class="col-span-full py-16 text-center bg-white rounded-[28px] shadow-soft p-8">
                    <div class="w-16 h-16 rounded-2xl bg-lilac text-grape flex items-center justify-center text-3xl mx-auto mb-4"><i class="bi bi-journal-x"></i></div>
                    <h4 class="font-fun text-xl font-semibold text-ink mb-1">No products found</h4>
                    <p class="text-[13px] text-slate-500 max-w-sm mx-auto mb-6">We couldn't find any products matching your filters. Try selecting another category or resetting the search.</p>
                    <a href="{{ route('catalog.index') }}" class="inline-flex items-center gap-2 bg-ink text-white text-[13px] font-bold px-6 h-12 rounded-full">
                        <i class="bi bi-arrow-counterclockwise text-sun"></i> Reset All Filters
                    </a>
                </div>
            @endforelse
        </div>

        <div class="mt-10">
            {{ $products->links() }}
        </div>
    </div>
</div>

<script>
    function toggleMobileFilters() {
        const sidebar = document.getElementById('catalogFiltersSidebar');
        sidebar.classList.toggle('hidden');
        if (!sidebar.classList.contains('hidden')) {
            sidebar.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    }
</script>
@endsection
