@php
    $compact = $compact ?? false;
    $collage = $bundle->items
        ->map(fn ($item) => $item->product?->card_image_url)
        ->filter()
        ->unique()
        ->take(4)
        ->values();
    $rotations = ['-rotate-6', 'rotate-6', 'rotate-2', '-rotate-3'];
    $positions = [
        'left-[6%] top-[12%] h-[52%] max-w-[60%]',
        'right-[7%] top-[9%] h-[58%] max-w-[42%]',
        'left-[20%] bottom-[7%] h-[44%] max-w-[46%]',
        'right-[24%] bottom-[9%] h-[40%] max-w-[34%]',
    ];
    $collageBg = ($index ?? 0) % 2 === 0 ? 'bg-peach' : 'bg-lilac';
@endphp

<div data-bundle-index="{{ $index ?? 0 }}" class="snap-center shrink-0 w-[86vw] max-w-[420px] lg:w-auto lg:max-w-none bg-cream text-slate-800 rounded-[24px] overflow-hidden flex flex-col {{ $compact ? 'xl:flex-row' : '' }} {{ $compact ? '' : 'shadow-soft' }}">
    <!-- Collage of what's inside -->
    <div class="{{ $compact ? 'h-56 xl:h-auto xl:w-[40%] xl:min-h-[300px]' : 'h-64 sm:h-72' }} {{ $collageBg }} relative overflow-hidden flex-shrink-0">
        @if($collage->isNotEmpty())
            @foreach($collage as $i => $img)
                <img src="{{ $img }}" alt="" loading="lazy" class="absolute {{ $positions[$i] }} w-auto rounded-xl shadow-lift {{ $rotations[$i] }} object-cover ring-4 ring-white" onerror="this.onerror=null; this.src='{{ asset('images/products/placeholder.svg') }}';">
            @endforeach
        @else
            <img src="{{ $bundle->image_url }}" alt="{{ $bundle->name }}" class="absolute inset-0 w-full h-full object-contain p-6" onerror="this.onerror=null; this.src='{{ asset('images/products/placeholder.svg') }}';">
        @endif
        <span class="absolute left-3 top-3 bg-sun text-ink text-[11px] font-bold px-2.5 py-1 rounded-full flex items-center gap-1 shadow-soft">
            <i class="bi bi-star-fill text-grape"></i>
            @if($compact)
                {{ $bundle->total_items_count }}-Item Package
            @else
                {{ str_replace(['Best Value', 'best value', 'Discount', 'discount'], ['Curated Set', 'Curated Set', 'Curated', 'Curated'], $bundle->badge ?? $bundle->total_items_count . '-Item Bundle') }}
            @endif
        </span>
    </div>

    <div class="flex-1 min-w-0 p-6 sm:p-7 flex flex-col">
        @if($compact)
            <span class="text-[12px] font-bold text-grape mb-1">Best for Ages 2–7</span>
        @else
            <div class="flex flex-wrap items-center gap-1.5 mb-2">
                <span class="bg-lilac text-grape text-[11px] font-bold px-2.5 py-1 rounded-full flex items-center gap-1"><i class="bi bi-box-seam-fill"></i> {{ $bundle->total_items_count }} Items Combo</span>
                <span class="bg-white text-slate-600 text-[11px] font-bold px-2.5 py-1 rounded-full border border-ink/10">Ages 3–8 yrs</span>
            </div>
        @endif

        <h3 class="font-fun font-semibold text-ink {{ $compact ? 'text-[24px]' : 'text-[28px]' }} leading-tight mb-1">{{ $bundle->name }}</h3>
        @unless($compact)
            <p class="text-[13px] font-bold text-grape mb-2">Best for: Family Devotions & Complete Early Learning</p>
        @endunless
        <p class="text-[13px] text-slate-500 leading-relaxed mb-4 {{ $compact ? 'line-clamp-3' : '' }}">{{ $bundle->description }}</p>

        <details class="group/details mb-5" {{ $compact ? '' : 'open' }}>
            <summary class="cursor-pointer list-none text-[13px] font-bold text-ink/80 hover:text-grape flex items-center gap-1.5 w-fit select-none">
                <i class="bi bi-box-seam-fill text-amber-500"></i>
                @if($compact)
                    See what's included ({{ $bundle->total_items_count }} items)
                @else
                    Products Included ({{ $bundle->total_items_count }} Items)
                @endif
                <i class="bi bi-chevron-down text-[10px] group-open/details:rotate-180 transition-transform"></i>
            </summary>
            <div class="grid grid-cols-1 {{ $compact ? '' : 'sm:grid-cols-2' }} gap-1.5 pt-3">
                @foreach($bundle->items as $item)
                    <div class="flex items-center gap-2 text-[12px] text-slate-700 bg-white px-3 py-2 rounded-xl">
                        <i class="bi bi-check-circle-fill text-emerald-600 flex-shrink-0"></i>
                        <span class="font-extrabold text-ink">{{ $item->quantity }}x</span>
                        <span class="font-semibold text-slate-800 line-clamp-1">{{ $item->display_name }}</span>
                    </div>
                @endforeach
            </div>
        </details>

        <div class="mt-auto flex flex-wrap items-end justify-between gap-x-4 gap-y-3 pt-5 border-t border-ink/10">
            <div>
                <span class="text-[11px] text-slate-400 font-semibold block">{{ $compact ? 'Bundle Price:' : 'All-in-One Price' }}</span>
                <span class="font-fun text-[26px] sm:text-[28px] font-semibold text-ink price-convertible leading-none" data-price-ngn="{{ $bundle->price }}">{{ $bundle->formatted_price }}</span>
            </div>
            <form action="{{ route('cart.addBundle', $bundle->id) }}" method="POST" onsubmit="{{ $formHandler }}(event)" class="m-0">
                @csrf
                <input type="hidden" name="quantity" value="1">
                <button type="submit" class="h-12 px-5 bg-ink hover:bg-inkdeep text-white font-bold rounded-full text-[13px] flex items-center gap-2 whitespace-nowrap transition cursor-pointer">
                    <i class="bi bi-bag-plus-fill text-sun"></i> <span>{{ $buttonLabel }}</span>
                </button>
            </form>
        </div>
    </div>
</div>
