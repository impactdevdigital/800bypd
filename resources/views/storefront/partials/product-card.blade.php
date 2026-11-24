@php
    $catSlug = $product->category->slug ?? null;
    $ageLabel = 'Ages 3+';
    $tileBg = 'bg-lilac';
    if ($catSlug === 'jigsaw-puzzles') { $ageLabel = 'Ages 3–8 yrs'; $tileBg = 'bg-peach'; }
    elseif ($catSlug === 'flashcards') { $ageLabel = 'Ages 2–6 yrs'; $tileBg = 'bg-lilac'; }
    elseif (in_array($catSlug, ['colouring-books', 'coloring-books'])) { $ageLabel = 'Ages 3–8 yrs'; $tileBg = 'bg-blush'; }
    elseif ($catSlug === 'storybooks') { $ageLabel = 'Ages 3–9 yrs'; $tileBg = 'bg-ink'; }

    [$cleanTitle, $subReference] = \App\Support\ProductTitle::split($product->name);
    $showDescription = $showDescription ?? true;
@endphp

<article class="group bg-white rounded-[24px] p-2.5 shadow-soft hover:shadow-lift transition duration-300 flex flex-col {{ $class ?? '' }}">
    <a href="{{ route('catalog.show', $product->slug) }}" class="block aspect-square rounded-[18px] overflow-hidden {{ $tileBg }} relative flex items-center justify-center p-4 sm:p-5">
        <img src="{{ $product->card_image_url }}"
             alt="{{ $product->name }}"
             loading="lazy"
             class="card-img max-w-full max-h-full object-contain rounded-lg drop-shadow-xl"
             onerror="this.onerror=null; this.src='{{ asset('images/products/placeholder.svg') }}';">
        @if($product->category)
            <span class="absolute left-2.5 top-2.5 bg-sun text-ink text-[11px] font-bold px-2.5 py-1 rounded-full">{{ $product->category->name }}</span>
        @endif
        @if($product->sale_price)
            <span class="absolute right-2.5 top-2.5 bg-white text-ink text-[11px] font-bold px-2.5 py-1 rounded-full">Special Offer</span>
        @endif
    </a>

    <div class="px-2.5 pt-4 pb-2 flex flex-col flex-1">
        <p class="text-[12px] font-bold mb-1 {{ $subReference ? 'text-grape' : 'text-slate-400' }}">
            {{ $subReference ?? 'Written by PD • 800byPD Original' }} <span class="text-slate-400 font-semibold">· {{ $ageLabel }}</span>
        </p>
        <h3 class="font-fun font-semibold text-ink text-[19px] leading-snug">
            <a href="{{ route('catalog.show', $product->slug) }}" class="hover:text-grape transition">{{ $cleanTitle }}</a>
        </h3>
        @if($showDescription)
            <p class="text-[13px] text-slate-500 line-clamp-2 leading-relaxed mt-1.5">{{ $product->description }}</p>
        @endif

        <div class="flex flex-wrap items-end justify-between gap-x-2 gap-y-3 mt-auto pt-4">
            <div class="min-w-0 mr-auto">
                @if($product->variants->isNotEmpty())
                    <span class="text-[11px] text-slate-400 font-semibold block leading-none mb-1">Starting at</span>
                @endif
                <span class="text-[19px] font-extrabold text-ink price-convertible leading-tight block truncate" data-price-ngn="{{ $product->sale_price ?? $product->price }}">{{ $product->formatted_price }}</span>
                @if($product->sale_price)
                    <span class="block text-[11px] line-through text-slate-400 price-convertible" data-price-ngn="{{ $product->price }}">{{ $product->formatted_original_price }}</span>
                @endif
            </div>

            @if($product->variants->isNotEmpty())
                <a href="{{ route('catalog.show', $product->slug) }}" class="h-11 px-4 rounded-full bg-ink hover:bg-inkdeep text-white text-[13px] font-bold flex items-center gap-2 whitespace-nowrap flex-shrink-0 transition">
                    <i class="bi bi-sliders text-sun"></i> <span>Choose Options</span>
                </a>
            @else
                <button type="button"
                    data-id="{{ $product->id }}"
                    data-name="{{ $product->name }}"
                    data-price="{{ $product->price }}"
                    data-saleprice="{{ $product->sale_price }}"
                    data-stock="{{ $product->stock_quantity }}"
                    data-desc="{{ $product->description }}"
                    data-category="{{ $product->category->name ?? 'Book' }}"
                    data-image="{{ $product->card_image_url }}"
                    onclick="triggerQuickAddFromBtn(this)"
                    class="h-11 px-4 rounded-full bg-ink hover:bg-inkdeep text-white text-[13px] font-bold flex items-center gap-2 whitespace-nowrap flex-shrink-0 transition cursor-pointer">
                    <i class="bi bi-box-seam text-sun"></i> <span>Add to Box</span>
                </button>
            @endif
        </div>
    </div>
</article>
