@extends('layouts.app')

@section('content')

<!-- Bundles Page Header -->
<section class="relative rounded-[28px] sm:rounded-[36px] bg-ink text-white overflow-hidden mb-8">
    <div class="absolute inset-0 dots-bg opacity-[.12] pointer-events-none"></div>
    <div class="relative grid lg:grid-cols-12 items-center">
        <div class="lg:col-span-7 p-6 sm:p-12">
            <span class="inline-flex items-center gap-2 bg-sun text-ink font-bold text-[11px] uppercase tracking-[.14em] px-3.5 py-1.5 rounded-full mb-5">
                <i class="bi bi-box2-heart-fill"></i> Curated Combinations
            </span>
            <h1 class="font-fun text-[36px] sm:text-[52px] font-semibold leading-[1.05] mb-4">Curated Bundles</h1>
            <p class="text-[15px] sm:text-[16px] text-indigo-200 leading-relaxed max-w-xl mb-7">
                Thoughtfully paired collections of scripture storybooks, Bible-verse jigsaw puzzles, biblical affirmation flashcards, and colouring books for comprehensive, faith-filled learning.
            </p>
            <a href="{{ route('catalog.index') }}" class="h-12 px-6 bg-white/10 hover:bg-white/20 border border-white/20 text-white font-bold text-[13px] rounded-full w-fit flex items-center gap-2 transition">
                <i class="bi bi-grid-fill text-sun"></i> Browse All Products
            </a>
        </div>
        <div class="hidden lg:block lg:col-span-5 relative h-full min-h-[340px]">
            <img src="{{ \App\Support\Img::sm('easy_puzzle_1_cut.jpg') }}" alt="" class="absolute right-[18%] top-[12%] w-[62%] rounded-2xl shadow-lift -rotate-6 ring-4 ring-white">
            <img src="{{ \App\Support\Img::sm('psalm_23_colouring_book_cover.jpg') }}" alt="" class="absolute right-[6%] top-[28%] w-[30%] rounded-xl shadow-lift rotate-6 ring-4 ring-white">
            <img src="{{ \App\Support\Img::sm('affirmations_flashcards_cover.jpg') }}" alt="" class="absolute right-[44%] bottom-[8%] w-[28%] rounded-xl shadow-lift rotate-3 ring-4 ring-white">
        </div>
    </div>
</section>

<!-- Category Quick Pills -->
<div class="mb-8 overflow-x-auto scrollbar-none -mx-4 px-4 sm:mx-0 sm:px-0 pb-1">
    <div class="flex items-center gap-2.5 min-w-max">
        <a href="{{ route('catalog.index') }}" class="h-11 px-5 rounded-full text-[13px] font-bold flex items-center gap-2 bg-white text-ink shadow-soft hover:bg-lilac transition">
            <i class="bi bi-grid-fill text-grape"></i> All Products
        </a>
        <a href="{{ route('bundles.index') }}" class="h-11 px-5 rounded-full text-[13px] font-bold flex items-center gap-2 bg-ink text-white">
            <i class="bi bi-box2-heart-fill text-sun"></i> Curated Bundles
            <span class="text-[10px] bg-white/15 text-sun px-2 py-0.5 rounded-full font-bold">{{ $bundles->count() }} Packages</span>
        </a>
        <a href="{{ route('catalog.index', ['category' => 'jigsaw-puzzles']) }}" class="h-11 px-5 rounded-full text-[13px] font-bold flex items-center gap-2 bg-white text-ink shadow-soft hover:bg-lilac transition">
            <i class="bi bi-puzzle-fill text-amber-500"></i> Jigsaw Puzzles
        </a>
        <a href="{{ route('catalog.index', ['category' => 'colouring-books']) }}" class="h-11 px-5 rounded-full text-[13px] font-bold flex items-center gap-2 bg-white text-ink shadow-soft hover:bg-lilac transition">
            <i class="bi bi-palette-fill text-pink-500"></i> Colouring Books
        </a>
        <a href="{{ route('catalog.index', ['category' => 'flashcards']) }}" class="h-11 px-5 rounded-full text-[13px] font-bold flex items-center gap-2 bg-white text-ink shadow-soft hover:bg-lilac transition">
            <i class="bi bi-card-text text-indigo-500"></i> Flashcards
        </a>
        <a href="{{ route('catalog.index', ['category' => 'storybooks']) }}" class="h-11 px-5 rounded-full text-[13px] font-bold flex items-center gap-2 bg-white text-ink shadow-soft hover:bg-lilac transition">
            <i class="bi bi-book-half text-emerald-500"></i> Storybooks
        </a>
    </div>
</div>

<!-- Bundles List -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-16">
    @forelse($bundles as $index => $bundle)
        <div class="[&>div]:w-full [&>div]:max-w-none">
            @include('storefront.partials.bundle-card', ['bundle' => $bundle, 'index' => $index, 'formHandler' => 'handleBundleAddToCart', 'buttonLabel' => 'Add Bundle to Cart', 'compact' => false])
        </div>
    @empty
        <div class="col-span-full py-16 text-center bg-white rounded-[28px] shadow-soft p-8">
            <div class="w-16 h-16 rounded-2xl bg-lilac text-grape flex items-center justify-center text-3xl mx-auto mb-4"><i class="bi bi-box2-heart"></i></div>
            <h4 class="font-fun text-xl font-semibold text-ink mb-1">Bundles are being updated</h4>
            <p class="text-[13px] text-slate-500 max-w-sm mx-auto mb-6">Please check back shortly or explore our individual collections.</p>
            <a href="{{ route('catalog.index') }}" class="inline-flex items-center gap-2 bg-ink text-white text-[13px] font-bold px-6 h-12 rounded-full">
                <i class="bi bi-grid-fill text-sun"></i> Browse All Products
            </a>
        </div>
    @endforelse
</div>

<!-- Custom Combinations Banner -->
<div class="rounded-[28px] bg-lilac overflow-hidden grid md:grid-cols-12 items-center">
    <div class="md:col-span-8 p-6 sm:p-10 flex flex-col sm:flex-row sm:items-center gap-5">
        <div class="w-14 h-14 bg-white text-grape rounded-2xl flex items-center justify-center text-2xl flex-shrink-0 shadow-soft">
            <i class="bi bi-stars"></i>
        </div>
        <div class="flex-1">
            <h4 class="font-fun font-semibold text-ink text-[22px] leading-tight">Looking for Custom Combinations?</h4>
            <p class="text-[14px] text-slate-600 mt-1">You can also explore individual books, puzzles, flashcards, and colouring sheets to build your own box.</p>
        </div>
        <a href="{{ route('catalog.index') }}" class="bg-grape hover:bg-purple-800 text-white font-bold text-[13px] px-6 h-12 rounded-full transition flex items-center gap-2 flex-shrink-0 w-fit">
            <span>Explore Full Catalog</span> <i class="bi bi-arrow-right"></i>
        </a>
    </div>
    <div class="hidden md:block md:col-span-4 h-full min-h-[200px] relative">
        <img src="{{ \App\Support\Img::sm('intermediate_puzzle_2_cover.jpg') }}" alt="" class="absolute inset-0 w-full h-full object-cover">
    </div>
</div>

<script>
function handleBundleAddToCart(e) {
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
</script>
@endsection
