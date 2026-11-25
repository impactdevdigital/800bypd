<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>800BYPD - Faith-Based Children's Books, Scripture Puzzles & Learning by PD</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v={{ @filemtime(public_path('css/app.css')) }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body class="bg-cream text-slate-800 antialiased flex flex-col min-h-screen overflow-x-clip">

    @php
        $cartService = app(\App\Services\CartService::class);
        $sessionCart = $cartService->getCart();
        $boxMetrics = $cartService->getBoxMetrics();
        $boxItemsTotal = $boxMetrics['total_items'];
        $cartSubtotalVal = $cartService->getSubtotal();
        $minBoxReq = $boxMetrics['required_minimum'];
    @endphp

    <!-- Top Trust Strip -->
    <div class="bg-inkdeep text-white/90 text-[12px] font-semibold">
        <div class="max-w-[1280px] mx-auto px-4 sm:px-8 h-9 flex items-center justify-center md:justify-between gap-6">
            <span class="hidden md:flex items-center gap-2"><i class="bi bi-shield-check text-sun"></i> Paystack SSL Secured</span>
            <span class="flex items-center gap-2"><i class="bi bi-truck text-sun"></i> Lagos (1–2 Days) &amp; Nationwide Delivery</span>
            <span class="hidden md:flex items-center gap-2"><i class="bi bi-flower1 text-sun"></i> Non-Toxic Child-Safe Materials</span>
        </div>
    </div>

    <!-- Main Navigation Bar -->
    <header class="bg-cream/90 backdrop-blur-md sticky top-0 z-40 border-b border-ink/5">
        <div class="max-w-[1280px] mx-auto px-4 sm:px-8 h-[72px] flex items-center justify-between gap-4">
            <!-- Brand Logo -->
            <a href="{{ route('home') }}" class="flex items-center gap-3 group flex-shrink-0">
                <div class="w-10 h-10 sm:w-11 sm:h-11 bg-sun text-ink rounded-2xl flex items-center justify-center font-fun font-bold text-xl sm:text-2xl shadow-soft rotate-3 group-hover:rotate-0 transition duration-300">8</div>
                <div class="leading-none">
                    <div class="font-fun text-xl sm:text-2xl font-bold text-ink">800BY<span class="text-amber-500">PD</span></div>
                    <div class="text-[9px] text-slate-400 font-bold uppercase tracking-[.2em] mt-1">Shaping Culture For Kids</div>
                </div>
            </a>

            <!-- Desktop Navigation Links -->
            <nav class="hidden lg:flex items-center gap-5 xl:gap-7 text-[13px] font-bold text-ink/80 whitespace-nowrap">
                <a href="{{ route('home') }}" class="py-2 hover:text-grape transition {{ request()->routeIs('home') ? 'text-ink' : '' }}">Home</a>

                <!-- Shop Categories Dropdown -->
                <div class="relative group">
                    <button type="button" class="flex items-center gap-1 py-2 hover:text-grape transition focus:outline-none {{ request()->routeIs('catalog.*') ? 'text-ink' : '' }}">
                        <span>Shop Categories</span>
                        <i class="bi bi-chevron-down text-[10px] group-hover:rotate-180 transition-transform duration-200"></i>
                    </button>
                    <div class="absolute left-1/2 -translate-x-1/2 top-full pt-3 w-[440px] hidden group-hover:block z-50">
                        <div class="bg-white rounded-[24px] shadow-lift border border-ink/5 p-3">
                            <div class="px-3 pt-2 pb-2 eyebrow !text-[10px] !text-slate-400">Product Collections</div>
                            <div class="grid grid-cols-2 gap-2">
                                @if(\App\Models\Category::isSlugActive('jigsaw-puzzles'))<a href="{{ route('catalog.index', ['category' => 'jigsaw-puzzles']) }}" class="group/item rounded-2xl overflow-hidden bg-peach hover:ring-2 hover:ring-grape/30 transition">
                                    <div class="h-20 overflow-hidden"><img src="{{ \App\Support\Img::sm('easy_puzzle_2_cut.jpg') }}" alt="" class="w-full h-full object-cover group-hover/item:scale-105 transition duration-300"></div>
                                    <div class="p-3"><span class="font-bold text-ink block text-[13px]">Jigsaw Puzzles</span><span class="text-[11px] text-slate-500 font-medium">Easy (6 pcs) & 12 pieces</span></div>
                                </a>@endif
                                @if(\App\Models\Category::isSlugActive('colouring-books'))<a href="{{ route('catalog.index', ['category' => 'colouring-books']) }}" class="group/item rounded-2xl overflow-hidden bg-blush hover:ring-2 hover:ring-grape/30 transition">
                                    <div class="h-20 overflow-hidden flex items-center justify-center p-2"><img src="{{ \App\Support\Img::sm('psalm_23_colouring_book_cover.jpg') }}" alt="" class="h-full object-contain group-hover/item:scale-105 transition duration-300 drop-shadow"></div>
                                    <div class="p-3"><span class="font-bold text-ink block text-[13px]">Colouring Books</span><span class="text-[11px] text-slate-500 font-medium">Creative doodle & premium thick pages</span></div>
                                </a>@endif
                                @if(\App\Models\Category::isSlugActive('flashcards'))<a href="{{ route('catalog.index', ['category' => 'flashcards']) }}" class="group/item rounded-2xl overflow-hidden bg-lilac hover:ring-2 hover:ring-grape/30 transition">
                                    <div class="h-20 overflow-hidden flex items-center justify-center p-2"><img src="{{ \App\Support\Img::sm('affirmations_flashcards_cover.jpg') }}" alt="" class="h-full object-contain group-hover/item:scale-105 transition duration-300 drop-shadow"></div>
                                    <div class="p-3"><span class="font-bold text-ink block text-[13px]">Flashcards</span><span class="text-[11px] text-slate-500 font-medium">Pocket & Big learning sizes</span></div>
                                </a>@endif
                                @if(\App\Models\Category::isSlugActive('storybooks'))<a href="{{ route('catalog.index', ['category' => 'storybooks']) }}" class="group/item rounded-2xl overflow-hidden bg-ink hover:ring-2 hover:ring-grape/30 transition">
                                    <div class="h-20 overflow-hidden flex items-center justify-center p-2"><img src="{{ asset('images/products/story_little_explorer.svg') }}" alt="" class="h-full object-contain group-hover/item:scale-105 transition duration-300"></div>
                                    <div class="p-3 bg-white"><span class="font-bold text-ink block text-[13px]">Storybooks</span><span class="text-[11px] text-slate-500 font-medium">Illustrated bedtime adventures</span></div>
                                </a>@endif
                            </div>
                            <a href="{{ route('catalog.index') }}" class="mt-2 flex items-center justify-between px-4 py-3 rounded-2xl hover:bg-lilac text-grape font-bold text-[13px] transition">
                                <span class="flex items-center gap-2"><i class="bi bi-grid-fill"></i> View All Products</span>
                                <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <a href="{{ route('bundles.index') }}" class="py-2 hover:text-grape transition flex items-center gap-1.5 {{ request()->routeIs('bundles.*') ? 'text-ink' : '' }}">Buy Bundles</a>
                <a href="{{ route('audios.index') }}" class="py-2 hover:text-grape transition flex items-center gap-1.5 {{ request()->routeIs('audios.*') ? 'text-ink' : '' }}"><i class="bi bi-spotify text-[#1DB954]"></i> Audios</a>
            </nav>

            <!-- Search, Cart & User Menu -->
            <div class="flex items-center gap-2 sm:gap-2.5">
                <form action="{{ route('catalog.index') }}" method="GET" class="hidden 2xl:flex items-center gap-2 bg-white border border-ink/10 rounded-full pl-4 pr-1.5 h-11 w-60 shadow-soft focus-within:border-grape transition">
                    <i class="bi bi-search text-ink/50 text-sm"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search books, audios..." class="flex-1 min-w-0 bg-transparent text-[13px] outline-none placeholder:text-slate-400">
                </form>
                <a href="{{ route('catalog.index') }}" class="hidden lg:flex 2xl:hidden w-11 h-11 rounded-full items-center justify-center text-ink hover:bg-lilac transition" aria-label="Search products"><i class="bi bi-search text-lg"></i></a>

                @auth
                    <div class="relative group hidden sm:block flex-shrink-0">
                        <a href="{{ in_array(auth()->user()->role, ['admin', 'staff']) ? route('admin.dashboard') : route('account.dashboard') }}" class="h-11 pl-1.5 pr-3 rounded-full flex items-center gap-2 text-ink hover:bg-lilac transition font-bold text-[13px]">
                            <span class="w-8 h-8 rounded-full bg-lilac text-grape flex items-center justify-center font-fun font-bold">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                            <span class="truncate max-w-[90px] hidden md:inline-block">{{ explode(' (', auth()->user()->name)[0] }}</span>
                            <i class="bi bi-chevron-down text-[10px] text-slate-400"></i>
                        </a>
                        <div class="absolute right-0 top-full pt-2 w-56 hidden group-hover:block z-50">
                            <div class="bg-white rounded-[20px] shadow-lift border border-ink/5 py-2 text-[13px] font-semibold">
                                @if(in_array(auth()->user()->role, ['admin', 'staff']))
                                    <div class="px-4 py-1 text-[10px] font-black uppercase tracking-wider text-slate-400">Admin Controls</div>
                                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 hover:bg-lilac text-grape font-bold"><i class="bi bi-speedometer2 mr-2"></i> Overview Dashboard</a>
                                    <a href="{{ route('admin.verifications') }}" class="block px-4 py-2 hover:bg-lilac text-slate-700"><i class="bi bi-receipt mr-2 text-amber-600"></i> Orders & Receipts</a>
                                    <a href="{{ route('admin.products.index') }}" class="block px-4 py-2 hover:bg-lilac text-slate-700"><i class="bi bi-journal-bookmark-fill mr-2 text-indigo-600"></i> Products</a>
                                    <div class="border-t border-slate-100 my-1"></div>
                                    <div class="px-4 py-1 text-[10px] font-black uppercase tracking-wider text-slate-400">Personal</div>
                                    <a href="{{ route('account.dashboard') }}" class="block px-4 py-2 hover:bg-lilac text-slate-700"><i class="bi bi-person-badge mr-2 text-slate-500"></i> Customer Portal</a>
                                @else
                                    <a href="{{ route('account.dashboard') }}" class="block px-4 py-2 hover:bg-lilac text-ink font-bold"><i class="bi bi-speedometer2 mr-2 text-grape"></i> Dashboard</a>
                                    <a href="{{ route('account.orders') }}" class="block px-4 py-2 hover:bg-lilac text-ink"><i class="bi bi-archive-fill mr-2 text-amber-600"></i> Order History</a>
                                @endif
                                <div class="border-t border-slate-100 my-1"></div>
                                <form action="{{ route('account.logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 hover:bg-rose-50 text-rose-700 font-bold"><i class="bi bi-box-arrow-right mr-2"></i> Log Out</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="hidden sm:flex h-11 px-4 rounded-full text-ink hover:bg-lilac font-bold text-[13px] items-center gap-2 transition flex-shrink-0">
                        <i class="bi bi-person text-lg"></i> Log In
                    </a>
                @endauth

                <button type="button" onclick="openCartSidebar()" class="relative h-11 bg-ink hover:bg-inkdeep text-white pl-4 pr-1.5 rounded-full font-bold text-[13px] flex items-center gap-2 shadow-soft transition flex-shrink-0 cursor-pointer" title="Fill Your Box ({{ $boxItemsTotal }}/{{ $minBoxReq }} items)">
                    <i class="bi bi-box-seam-fill text-sun"></i>
                    <span class="hidden sm:inline">My Box</span>
                    <span id="headerBoxActivityTag">
                        @if($boxItemsTotal > 0 && $boxItemsTotal < $minBoxReq)
                            <span class="hidden md:inline text-[10px] bg-amber-400/20 text-amber-200 px-1.5 py-0.5 rounded-md font-extrabold">{{ $minBoxReq - $boxItemsTotal }} more</span>
                        @elseif($boxItemsTotal >= $minBoxReq)
                            <span class="hidden md:inline text-[10px] bg-emerald-400/20 text-emerald-300 px-1.5 py-0.5 rounded-md font-extrabold">Box Full</span>
                        @endif
                    </span>
                    <span id="cartCountBadge" class="bg-sun text-ink font-black min-w-8 h-8 px-1 rounded-full text-[12px] flex items-center justify-center">{{ $boxItemsTotal }}</span>
                </button>

                <!-- Mobile Hamburger Button -->
                <button id="mobileMenuBtn" onclick="toggleMobileMenu(event)" class="lg:hidden w-11 h-11 rounded-full flex items-center justify-center text-2xl text-ink hover:bg-lilac transition focus:outline-none" aria-label="Open menu">
                    <i class="bi bi-list"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Navigation Menu Drawer -->
        <div id="mobileMenuDrawer" class="hidden lg:hidden bg-cream border-t border-ink/5 px-4 pt-4 pb-6 space-y-5 shadow-lift max-h-[calc(100vh-108px)] overflow-y-auto">
            <form action="{{ route('catalog.index') }}" method="GET" class="flex items-center gap-2 bg-white border border-ink/10 rounded-full px-4 h-12">
                <i class="bi bi-search text-ink/50 text-sm"></i>
                <input type="text" name="search" placeholder="Search books, audios..." class="flex-1 bg-transparent text-sm outline-none">
            </form>

            <nav class="flex flex-col gap-1 text-[15px] font-bold text-ink">
                <a href="{{ route('home') }}" class="px-3 py-3 rounded-2xl hover:bg-lilac transition flex items-center justify-between">Home <i class="bi bi-chevron-right text-xs text-slate-400"></i></a>
                <a href="{{ route('bundles.index') }}" class="px-3 py-3 rounded-2xl bg-peach transition flex items-center justify-between">
                    <span class="flex items-center gap-2"><i class="bi bi-box2-heart-fill text-amber-500"></i> Buy Our Bundles</span>
                    <span class="bg-ink text-sun text-[10px] font-black px-2 py-0.5 rounded-full uppercase">Curated</span>
                </a>
                <a href="{{ route('catalog.index') }}" class="px-3 py-3 rounded-2xl hover:bg-lilac transition flex items-center justify-between">All Products Catalog <i class="bi bi-chevron-right text-xs text-slate-400"></i></a>
                <a href="{{ route('audios.index') }}" class="px-3 py-3 rounded-2xl hover:bg-lilac transition flex items-center justify-between"><span class="flex items-center gap-2"><i class="bi bi-spotify text-[#1DB954]"></i> Spotify Storytime Audios</span> <i class="bi bi-chevron-right text-xs text-slate-400"></i></a>
            </nav>

            <div>
                <span class="eyebrow !text-[10px] !text-slate-400 px-1 block mb-2">Collections & Categories</span>
                <div class="grid grid-cols-2 gap-2.5">
                    @if(\App\Models\Category::isSlugActive('jigsaw-puzzles'))<a href="{{ route('catalog.index', ['category' => 'jigsaw-puzzles']) }}" class="rounded-2xl overflow-hidden bg-white shadow-soft">
                        <div class="h-20 bg-peach overflow-hidden"><img src="{{ \App\Support\Img::sm('easy_puzzle_2_cut.jpg') }}" alt="" class="w-full h-full object-cover"></div>
                        <div class="px-3 py-2"><span class="block text-ink font-bold text-[13px]">Puzzles</span><span class="text-[11px] text-slate-400">6 & 12 pcs</span></div>
                    </a>@endif
                    @if(\App\Models\Category::isSlugActive('colouring-books'))<a href="{{ route('catalog.index', ['category' => 'colouring-books']) }}" class="rounded-2xl overflow-hidden bg-white shadow-soft">
                        <div class="h-20 bg-blush flex items-center justify-center p-2"><img src="{{ \App\Support\Img::sm('psalm_23_colouring_book_cover.jpg') }}" alt="" class="h-full object-contain"></div>
                        <div class="px-3 py-2"><span class="block text-ink font-bold text-[13px]">Colouring</span><span class="text-[11px] text-slate-400">Doodle Books</span></div>
                    </a>@endif
                    @if(\App\Models\Category::isSlugActive('flashcards'))<a href="{{ route('catalog.index', ['category' => 'flashcards']) }}" class="rounded-2xl overflow-hidden bg-white shadow-soft">
                        <div class="h-20 bg-lilac flex items-center justify-center p-2"><img src="{{ \App\Support\Img::sm('affirmations_flashcards_cover.jpg') }}" alt="" class="h-full object-contain"></div>
                        <div class="px-3 py-2"><span class="block text-ink font-bold text-[13px]">Flashcards</span><span class="text-[11px] text-slate-400">Pocket & Big</span></div>
                    </a>@endif
                    @if(\App\Models\Category::isSlugActive('storybooks'))<a href="{{ route('catalog.index', ['category' => 'storybooks']) }}" class="rounded-2xl overflow-hidden bg-white shadow-soft">
                        <div class="h-20 bg-ink flex items-center justify-center p-2"><img src="{{ asset('images/products/story_little_explorer.svg') }}" alt="" class="h-full object-contain"></div>
                        <div class="px-3 py-2"><span class="block text-ink font-bold text-[13px]">Storybooks</span><span class="text-[11px] text-slate-400">Bedtime Tales</span></div>
                    </a>@endif
                </div>
            </div>

            <div class="pt-1">
                @auth
                    <div class="space-y-2 text-[13px] font-bold">
                        <div class="text-slate-500 text-xs px-1">Logged in as: <strong class="text-slate-800">{{ auth()->user()->name }}</strong></div>
                        @if(in_array(auth()->user()->role, ['admin', 'staff']))
                            <a href="{{ route('admin.dashboard') }}" class="block bg-grape text-white p-3.5 rounded-2xl"><i class="bi bi-speedometer2 mr-2 text-sun"></i> Admin Overview Dashboard</a>
                            <a href="{{ route('admin.verifications') }}" class="block bg-peach text-amber-900 p-3.5 rounded-2xl"><i class="bi bi-receipt text-amber-600 mr-2"></i> Orders & Payment Receipts</a>
                        @endif
                        <a href="{{ route('account.dashboard') }}" class="block bg-white shadow-soft p-3.5 rounded-2xl text-ink"><i class="bi bi-person-badge text-grape mr-2"></i> Customer Portal</a>
                        <a href="{{ route('account.orders') }}" class="block bg-white shadow-soft p-3.5 rounded-2xl text-ink"><i class="bi bi-archive-fill text-amber-600 mr-2"></i> My Order History</a>
                        <form action="{{ route('account.logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full text-left bg-rose-50 text-rose-700 p-3.5 rounded-2xl font-bold"><i class="bi bi-box-arrow-right mr-2"></i> Log Out</button>
                        </form>
                    </div>
                @else
                    <div class="grid grid-cols-2 gap-3 text-[13px]">
                        <a href="{{ route('login') }}" class="bg-ink text-white font-bold h-12 rounded-full flex items-center justify-center">Log In</a>
                        <a href="{{ route('register') }}" class="bg-white border border-ink/15 text-ink font-bold h-12 rounded-full flex items-center justify-center">Create Account</a>
                    </div>
                @endauth
            </div>
        </div>
    </header>

    @if(request()->routeIs('home'))
    <!-- Spotify Storytime Banner (Homepage Only) -->
    <div class="bg-grape text-white text-[13px] font-semibold">
        <div class="max-w-[1280px] mx-auto px-4 sm:px-8 py-2.5 flex flex-col sm:flex-row justify-between items-center gap-2">
            <div class="flex items-center gap-2 text-center sm:text-left">
                <i class="bi bi-spotify text-sun text-base flex-shrink-0"></i>
                <span><strong>Spotify Storytime Companion:</strong> Listen to 800BYPD children's audiobooks &amp; podcasts narrated by PD!</span>
            </div>
            <a href="{{ route('audios.index') }}" class="bg-sun hover:bg-yellow-300 text-ink font-bold px-4 py-1.5 rounded-full text-[12px] transition flex-shrink-0">
                Explore Audios <i class="bi bi-play-fill ml-0.5"></i>
            </a>
        </div>
    </div>
    @endif

    <!-- Flash Messages -->
    @if(session('success') || session('error'))
    <div class="max-w-[1280px] mx-auto px-4 sm:px-8 mt-5 w-full">
        @if(session('success'))
            <div class="bg-mint text-emerald-900 px-5 py-3.5 rounded-2xl text-[13px] font-semibold flex items-center gap-2.5">
                <i class="bi bi-check-circle-fill text-base text-emerald-600"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif
        @if(session('error'))
            <div class="bg-rose-50 text-rose-900 px-5 py-3.5 rounded-2xl text-[13px] font-semibold flex items-center gap-2.5">
                <i class="bi bi-exclamation-circle-fill text-base text-rose-600"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif
    </div>
    @endif

    <!-- Main Body Content -->
    <main class="flex-grow max-w-[1280px] mx-auto w-full px-4 sm:px-8 py-6 sm:py-10">
        @yield('content')
    </main>

    @if(!request()->routeIs('cart.index') && !request()->routeIs('checkout.show'))
    <!-- Floating Cart Bar -->
    <div id="floatingCartBar" class="{{ $boxItemsTotal > 0 ? '' : 'hidden' }} fixed bottom-4 left-3 sm:bottom-6 sm:left-6 z-40 max-w-[calc(100vw-5.5rem)] sm:max-w-none transition-all duration-300">
        <div class="bg-ink text-white pl-2 pr-2 py-2 rounded-full shadow-lift flex items-center gap-2 sm:gap-3">
            <button type="button" onclick="openCartSidebar()" class="flex items-center gap-2.5 text-left focus:outline-none group cursor-pointer">
                <div class="w-9 h-9 rounded-full bg-sun text-ink flex items-center justify-center text-sm flex-shrink-0 group-hover:scale-105 transition">
                    <i class="bi bi-box-seam-fill"></i>
                </div>
                <div>
                    <div class="flex items-center gap-1.5 leading-none">
                        <span class="text-[9px] text-indigo-200 uppercase font-black tracking-wider">Your Box</span>
                        <span id="floatingCartActivityBadge" class="text-[9px] font-black px-1.5 py-0.5 rounded-md leading-none {{ $boxMetrics['is_box_full'] ? 'bg-emerald-400/25 text-emerald-300' : 'bg-amber-400/20 text-amber-300' }}">
                            {{ $boxMetrics['is_box_full'] ? 'Box Full' : ($boxMetrics['remaining_items'] . ' more to fill') }}
                        </span>
                    </div>
                    <div class="text-[12px] font-black leading-tight mt-1 whitespace-nowrap">
                        <span id="floatingCartItemCount">{{ $boxItemsTotal }}</span>
                        <span id="floatingCartItemLabel">{{ $boxItemsTotal === 1 ? 'Item' : 'Items' }}</span>
                        <span class="text-indigo-300 font-normal">·</span>
                        <span id="floatingCartSubtotal" class="text-sun price-convertible" data-price-ngn="{{ $cartSubtotalVal }}">₦{{ number_format($cartSubtotalVal, 2) }}</span>
                    </div>
                </div>
            </button>
            <button type="button" onclick="openCartSidebar()" class="bg-sun hover:bg-yellow-300 text-ink font-bold text-[12px] px-4 h-9 rounded-full transition flex items-center gap-1 whitespace-nowrap cursor-pointer">
                <span>View Box</span> <i class="bi bi-arrow-right"></i>
            </button>
        </div>
    </div>
    @endif

    <!-- Cart Sidebar Drawer ("View Box") -->
    <div id="cartSidebarDrawer" class="fixed inset-0 z-50 hidden transition-opacity duration-300" aria-labelledby="cartSidebarTitle" role="dialog" aria-modal="true">
        <div id="cartSidebarBackdrop" onclick="closeCartSidebar()" class="fixed inset-0 bg-inkdeep/50 backdrop-blur-sm transition-opacity duration-300 opacity-0 cursor-pointer"></div>

        <div class="fixed inset-y-0 right-0 max-w-full flex pl-6 sm:pl-10">
            <div id="cartSidebarPanel" class="w-screen max-w-md sm:max-w-lg bg-cream shadow-2xl flex flex-col transform translate-x-full transition-transform duration-300 ease-in-out sm:rounded-l-[28px] overflow-hidden">
                <!-- Header -->
                <div class="px-5 sm:px-6 pt-5 pb-4 flex items-center justify-between flex-shrink-0">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-2xl bg-sun text-ink flex items-center justify-center rotate-3">
                            <i class="bi bi-box-seam-fill"></i>
                        </div>
                        <div>
                            <h2 id="cartSidebarTitle" class="font-fun text-xl font-semibold text-ink leading-tight flex items-center gap-2">
                                <span>Your Box</span>
                                <span id="sidebarItemCountBadge" class="bg-lilac text-grape text-[11px] font-bold px-2 py-0.5 rounded-full leading-none font-sans">{{ $boxItemsTotal }} {{ $boxItemsTotal === 1 ? 'item' : 'items' }}</span>
                            </h2>
                            <p class="text-[12px] text-slate-500">Curated children's books, puzzles & learning</p>
                        </div>
                    </div>
                    <button type="button" onclick="closeCartSidebar()" class="w-10 h-10 rounded-full bg-white shadow-soft text-ink flex items-center justify-center hover:bg-lilac transition focus:outline-none cursor-pointer" aria-label="Close sidebar">
                        <i class="bi bi-x-lg text-sm"></i>
                    </button>
                </div>

                <!-- "Fill Your Box" Activity Tracker -->
                <div id="sidebarBoxActivityCard" class="mx-5 sm:mx-6 mb-3 px-4 py-3.5 bg-white rounded-2xl shadow-soft flex flex-col gap-2 flex-shrink-0">
                    <div class="flex items-center justify-between text-xs font-bold">
                        <div class="flex items-center gap-1.5 text-ink">
                            <span id="sidebarActivityIcon">
                                @if($boxMetrics['is_box_full'])
                                    <i class="bi bi-box2-heart-fill text-emerald-500"></i>
                                @else
                                    <i class="bi bi-box-seam text-amber-500"></i>
                                @endif
                            </span>
                            <span id="sidebarActivityHeading" class="text-xs font-black uppercase tracking-wide">
                                {{ $boxMetrics['is_box_full'] ? 'Box Complete' : 'Fill Your Box Activity' }}
                            </span>
                        </div>
                        <span id="sidebarActivityRatio" class="text-grape font-black">{{ $boxMetrics['total_items'] }} / {{ $boxMetrics['required_minimum'] }} items</span>
                    </div>
                    <div class="w-full bg-lilac rounded-full h-2.5 overflow-hidden">
                        <div id="sidebarProgressBar" class="h-full rounded-full transition-all duration-500 ease-out {{ $boxMetrics['is_box_full'] ? 'bg-emerald-500' : 'bg-gradient-to-r from-[#7C3AED] to-[#FACC15]' }}" style="width: {{ $boxMetrics['progress_percent'] }}%"></div>
                    </div>
                    <p id="sidebarActivityMessage" class="text-[12px] font-semibold text-slate-600 flex items-center gap-1.5">
                        @if($boxMetrics['is_box_full'])
                            <i class="bi bi-stars text-amber-500"></i> <span>{{ $boxMetrics['prompt_message'] }}</span>
                        @else
                            <i class="bi bi-info-circle-fill text-grape"></i> <span>{{ $boxMetrics['prompt_message'] }}</span>
                        @endif
                    </p>
                </div>

                <!-- Items List -->
                <div id="sidebarItemsContainer" class="flex-1 overflow-y-auto px-5 sm:px-6 py-2 space-y-3 {{ $boxItemsTotal > 0 ? '' : 'hidden' }}"></div>

                <!-- Empty State -->
                <div id="sidebarEmptyState" class="{{ $boxItemsTotal === 0 ? '' : 'hidden' }} flex-1 flex flex-col items-center justify-center p-8 text-center">
                    <div class="relative w-40 h-28 mb-5">
                        <img src="{{ \App\Support\Img::sm('psalm_23_colouring_book_cover.jpg') }}" alt="" class="absolute left-2 top-2 w-16 rounded-lg shadow-lift -rotate-6">
                        <img src="{{ \App\Support\Img::sm('affirmations_flashcards_cover.jpg') }}" alt="" class="absolute right-2 top-0 w-16 rounded-lg shadow-lift rotate-6">
                        <img src="{{ \App\Support\Img::sm('easy_puzzle_3_cut.jpg') }}" alt="" class="absolute left-1/2 -translate-x-1/2 bottom-0 w-24 rounded-lg shadow-lift">
                    </div>
                    <h3 class="font-fun font-semibold text-ink text-xl mb-1">Your Box is Empty</h3>
                    <p class="text-[13px] text-slate-500 max-w-xs mb-6">Start adding inspiring storybooks, scripture puzzles, flashcards, or colouring books to fill your box.</p>
                    <a href="{{ route('catalog.index') }}" onclick="closeCartSidebar()" class="bg-ink hover:bg-inkdeep text-white font-bold text-[13px] px-6 h-12 rounded-full transition inline-flex items-center gap-2">
                        <i class="bi bi-grid-fill text-sun"></i> Browse Collections
                    </a>
                </div>

                <!-- Sidebar Footer -->
                <div id="sidebarFooter" class="p-5 sm:p-6 bg-white space-y-4 flex-shrink-0 shadow-[0_-12px_24px_-16px_rgba(49,46,129,.25)]">
                    <div class="flex items-end justify-between">
                        <div>
                            <span class="text-[11px] text-slate-400 uppercase font-black tracking-wider block">Estimated Subtotal</span>
                            <span class="text-[12px] text-slate-500">Excludes delivery (added at checkout)</span>
                        </div>
                        <span id="sidebarSubtotal" class="font-fun font-semibold text-2xl text-ink price-convertible" data-price-ngn="{{ $cartSubtotalVal }}">₦{{ number_format($cartSubtotalVal, 2) }}</span>
                    </div>
                    <div class="grid grid-cols-2 gap-2.5">
                        <a href="{{ route('cart.index') }}" class="bg-lilac hover:bg-purple-100 text-ink font-bold h-12 rounded-full text-[13px] flex items-center justify-center gap-1.5 transition">
                            <i class="bi bi-cart3"></i> <span>View Full Cart</span>
                        </a>
                        @if($boxMetrics['is_box_full'])
                            <a id="sidebarCheckoutBtn" href="{{ route('checkout.show') }}" class="bg-ink hover:bg-inkdeep text-white font-bold h-12 rounded-full text-[13px] flex items-center justify-center gap-1.5 transition">
                                <span>Checkout</span> <i class="bi bi-arrow-right"></i>
                            </a>
                        @else
                            <a id="sidebarCheckoutBtn" href="javascript:void(0)" onclick="showToastNotification('Add {{ $boxMetrics['remaining_items'] }} more {{ $boxMetrics['remaining_items'] === 1 ? 'item' : 'items' }} to fill your box before checkout!')" class="bg-slate-200 text-slate-500 font-bold h-12 rounded-full text-[13px] flex items-center justify-center gap-1.5 transition cursor-pointer">
                                <span>Checkout</span> <i class="bi bi-lock-fill text-xs"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(request()->routeIs('home'))
        <!-- Scroll to Top Button (Homepage Only) -->
        <button id="scrollToTopBtn" onclick="window.scrollTo({top: 0, behavior: 'smooth'})" class="fixed bottom-20 right-4 sm:bottom-24 sm:right-6 z-40 bg-white text-ink w-11 h-11 sm:w-12 sm:h-12 rounded-full shadow-lift hidden items-center justify-center text-lg transition hover:-translate-y-0.5 focus:outline-none" title="Scroll to top">
            <i class="bi bi-arrow-up"></i>
        </button>
    @endif

    <!-- Floating WhatsApp Support Button -->
    <a href="https://wa.me/2348164254442?text=Hello%20800byPD!%20I%20have%20a%20question%20about%20your%20children%27s%20books%20and%20puzzles." target="_blank" class="fixed bottom-4 right-4 sm:bottom-6 sm:right-6 z-50 bg-[#25D366] hover:bg-emerald-600 text-white rounded-full w-12 h-12 sm:w-14 sm:h-14 shadow-lift flex items-center justify-center group transition hover:-translate-y-0.5" aria-label="Chat with 800byPD">
        <i class="bi bi-whatsapp text-2xl sm:text-[26px]"></i>
        <span class="absolute right-full mr-3 whitespace-nowrap bg-ink text-white text-[12px] font-bold px-3 py-1.5 rounded-full opacity-0 group-hover:opacity-100 transition pointer-events-none">Chat with 800byPD</span>
    </a>

    <!-- Quick-Add Product Modal -->
    <div id="quickAddModal" class="fixed inset-0 bg-inkdeep/60 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
        <div class="bg-cream rounded-[28px] max-w-md w-full shadow-2xl overflow-hidden relative">
            <button onclick="closeQuickAddModal()" class="absolute top-4 right-4 z-20 w-10 h-10 rounded-full bg-white/95 text-ink flex items-center justify-center hover:bg-white transition shadow-soft" aria-label="Close">
                <i class="bi bi-x-lg text-sm"></i>
            </button>
            <div class="h-64 sm:h-72 bg-lilac relative overflow-hidden flex items-center justify-center p-6">
                <img id="quickAddImage" src="" alt="Product Cover" class="max-h-full max-w-full object-contain drop-shadow-xl rounded-lg" onerror="this.onerror=null; this.src='{{ asset('images/products/placeholder.svg') }}';">
                <div id="quickAddPlaceholderIcon" class="hidden text-center p-6">
                    <i class="bi bi-book-half text-6xl text-sun mb-2"></i>
                    <span class="block text-xs font-bold text-slate-400">800byPD Original</span>
                </div>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <span id="quickAddCategory" class="eyebrow !text-[11px]">Category</span>
                    <h3 id="quickAddTitle" class="font-fun font-semibold text-ink text-2xl leading-tight mt-1">Product Title</h3>
                    <p id="quickAddDescription" class="text-[13px] text-slate-500 line-clamp-2 mt-1"></p>
                </div>
                <div class="flex items-center gap-2">
                    <span id="quickAddStock" class="bg-mint text-emerald-700 text-[11px] font-bold px-2.5 py-1 rounded-full uppercase">In Stock</span>
                </div>
                <div class="pt-1 flex items-center gap-3">
                    <div class="flex items-center bg-white p-1 rounded-full shadow-soft text-sm font-bold">
                        <button type="button" onclick="changeModalQty(-1)" class="w-10 h-10 rounded-full text-ink hover:bg-lilac transition flex items-center justify-center" aria-label="Decrease">-</button>
                        <span id="quickAddQtyDisplay" class="w-8 text-center text-ink font-extrabold">1</span>
                        <button type="button" onclick="changeModalQty(1)" class="w-10 h-10 rounded-full text-ink hover:bg-lilac transition flex items-center justify-center" aria-label="Increase">+</button>
                    </div>
                    <button type="button" onclick="submitQuickAddModal()" id="quickAddSubmitBtn" class="flex-1 bg-ink hover:bg-inkdeep text-white font-bold h-12 px-5 rounded-full transition flex items-center justify-center gap-2 text-[13px]">
                        <i class="bi bi-box-seam text-sun"></i>
                        <span>Add to Box</span>
                        <span id="quickAddBtnPriceDisplay" class="price-convertible text-sun" data-price-ngn="0">₦0.00</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
    <div id="toastNotification" class="fixed top-24 right-4 sm:right-6 z-50 hidden bg-ink text-white px-5 py-3.5 rounded-2xl shadow-lift text-[13px] font-semibold flex items-center gap-2.5 transition max-w-[calc(100vw-2rem)]">
        <i class="bi bi-check-circle-fill text-sun text-base"></i>
        <span id="toastMessage">Product added to cart!</span>
    </div>

    <!-- Spotify Channel Popup Modal -->
    <div id="spotifyModal" class="fixed inset-0 bg-inkdeep/60 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
        <div class="bg-inkdeep text-white rounded-[28px] p-6 sm:p-7 max-w-lg w-full shadow-2xl relative overflow-hidden">
            <div class="absolute -right-16 -top-16 w-56 h-56 rounded-full bg-grape/40 blur-2xl"></div>
            <button onclick="closeSpotifyModal()" class="absolute top-4 right-4 w-10 h-10 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center" aria-label="Close">
                <i class="bi bi-x-lg text-sm"></i>
            </button>
            <div class="relative flex items-center gap-3 mb-5 pr-10">
                <span class="w-12 h-12 rounded-2xl bg-[#1DB954] flex items-center justify-center text-2xl flex-shrink-0"><i class="bi bi-spotify"></i></span>
                <div>
                    <h3 class="font-fun font-semibold text-2xl leading-tight">Spotify Audio Channel</h3>
                    <p class="text-[13px] text-indigo-200">Listen to bedtime story audiobooks and podcasts narrated by PD.</p>
                </div>
            </div>
            <div class="relative mb-5">
                <x-spotify-player height="232" />
            </div>
            <a href="{{ \App\Support\Spotify::listenUrl() }}" target="_blank" rel="noopener" class="relative w-full bg-[#1DB954] hover:bg-emerald-600 text-white font-bold h-12 rounded-full text-[13px] flex items-center justify-center gap-2">
                Open Spotify App <i class="bi bi-box-arrow-up-right"></i>
            </a>
        </div>
    </div>

    @if(!request()->routeIs('catalog.show'))
    <!-- Footer -->
    <footer class="bg-ink text-indigo-200 mt-16 sm:mt-24">
        <div class="max-w-[1280px] mx-auto px-4 sm:px-8 py-14 grid sm:grid-cols-2 lg:grid-cols-12 gap-10 text-[13px]">
            <div class="lg:col-span-4">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 bg-sun text-ink rounded-xl flex items-center justify-center font-fun font-bold text-xl rotate-3">8</div>
                    <span class="font-fun text-2xl font-bold text-white">800BY<span class="text-sun">PD</span></span>
                </div>
                <p class="leading-relaxed mb-4 max-w-sm">Faith-filled children's bookstore and audio workshop created by <strong class="text-white">PD</strong>. Nurturing young hearts in God's love, character, and wisdom through scripture puzzles, biblical affirmations, illustrated storybooks, and audio episodes.</p>
                <p class="text-sun font-bold"><i class="bi bi-geo-alt-fill mr-1"></i> Based in Lagos, Nigeria</p>
            </div>

            <div class="lg:col-span-2">
                <h4 class="text-white font-fun text-base font-semibold mb-4">Quick Links</h4>
                <ul class="space-y-3">
                    <li><a href="{{ route('catalog.index') }}" class="hover:text-sun transition">Explore All Products</a></li>
                    <li><a href="{{ route('bundles.index') }}" class="hover:text-sun transition">Curated Value Bundles</a></li>
                    <li><a href="{{ route('audios.index') }}" class="hover:text-sun transition">Spotify Audiobooks</a></li>
                    <li><a href="{{ auth()->check() ? (in_array(auth()->user()->role, ['admin', 'staff']) ? route('admin.dashboard') : route('account.dashboard')) : route('login') }}" class="hover:text-sun transition">Customer Account</a></li>
                </ul>
            </div>

            <div class="lg:col-span-3">
                <h4 class="text-white font-fun text-base font-semibold mb-4">Customer Care &amp; Delivery</h4>
                <ul class="space-y-3">
                    <li><a href="https://wa.me/2348164254442" target="_blank" class="hover:text-sun transition flex items-center gap-2"><i class="bi bi-whatsapp text-emerald-400"></i> +234 816 425 4442</a></li>
                    <li><a href="mailto:800bypd@gmail.com" class="hover:text-sun transition flex items-center gap-2"><i class="bi bi-envelope-fill text-[#A78BFA]"></i> 800bypd@gmail.com</a></li>
                    <li class="flex items-center gap-2"><i class="bi bi-truck text-amber-300"></i> Lagos: 1–2 Days Flat</li>
                    <li class="flex items-center gap-2"><i class="bi bi-send-check text-purple-300"></i> Nationwide: 3–5 Days Tracked</li>
                </ul>
            </div>

            <div class="lg:col-span-3">
                <h4 class="text-white font-fun text-base font-semibold mb-4">Secure Shopping</h4>
                <ul class="space-y-3">
                    <li class="flex items-center gap-2"><i class="bi bi-shield-lock-fill text-emerald-400"></i> Paystack 256-Bit SSL Encryption</li>
                    <li class="flex items-center gap-2"><i class="bi bi-credit-card-fill text-sun"></i> Cards, Direct Transfer &amp; USSD</li>
                    <li class="flex items-center gap-2"><i class="bi bi-flower1 text-pink-300"></i> 100% Non-Toxic Child-Safe Board</li>
                </ul>
                <button onclick="openSpotifyModal()" class="mt-5 bg-[#1DB954] hover:bg-emerald-600 text-white font-bold px-5 h-11 rounded-full text-[13px] inline-flex items-center gap-2 transition cursor-pointer">
                    <i class="bi bi-spotify"></i> Listen on Spotify
                </button>
            </div>
        </div>

        <div class="border-t border-white/10">
            <div class="max-w-[1280px] mx-auto px-4 sm:px-8 py-5 text-[12px] flex flex-col md:flex-row justify-between items-center gap-2 text-center">
                <p>&copy; {{ date('Y') }} <strong class="text-white">800BYPD</strong>. All rights reserved.</p>
                <p class="flex flex-wrap items-center justify-center gap-x-4 gap-y-1">
                    <span><i class="bi bi-shield-check text-sun"></i> Paystack SSL Secured</span>
                    <span><i class="bi bi-flower1 text-sun"></i> Non-Toxic Child-Safe Materials</span>
                    <span><i class="bi bi-truck text-sun"></i> Fast Nationwide Delivery</span>
                </p>
            </div>
        </div>
    </footer>
    @endif

    <!-- Currency Conversion & Quick Add Modal Script -->
    <script>
        const exchangeRates = { NGN: 1, USD: 0.00065, GBP: 0.00051, EUR: 0.00060 };
        const currencySymbols = { NGN: '₦', USD: '$', GBP: '£', EUR: '€' };
        const currencyNames = { NGN: 'Naira (₦)', USD: 'US Dollars ($)', GBP: 'British Pounds (£)', EUR: 'Euros (€)' };

        function changeCurrency(curr) {
            sessionStorage.setItem('selected_currency', curr);

            document.querySelectorAll('.price-convertible').forEach(el => {
                const baseNaira = parseFloat(el.getAttribute('data-price-ngn'));
                if (!isNaN(baseNaira)) {
                    const converted = (baseNaira * exchangeRates[curr]).toFixed(2);
                    const formatted = parseFloat(converted).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                    el.textContent = currencySymbols[curr] + formatted;
                }
            });

            document.querySelectorAll('.currency-name').forEach(el => {
                el.textContent = currencyNames[curr] || curr;
            });
        }

        function toggleMobileMenu(e) {
            if (e) e.stopPropagation();
            const drawer = document.getElementById('mobileMenuDrawer');
            if (drawer) drawer.classList.toggle('hidden');
        }

        // 5.1 Close mobile menu when clicking/tapping outside
        document.addEventListener('click', function (e) {
            const drawer = document.getElementById('mobileMenuDrawer');
            const menuBtn = document.getElementById('mobileMenuBtn');
            if (drawer && !drawer.classList.contains('hidden')) {
                if (!drawer.contains(e.target) && (!menuBtn || !menuBtn.contains(e.target))) {
                    drawer.classList.add('hidden');
                }
            }
        });

        // 6.2 Scroll to Top Button Visibility Listener
        window.addEventListener('scroll', function () {
            const btn = document.getElementById('scrollToTopBtn');
            if (btn) {
                if (window.scrollY > 300) {
                    btn.classList.remove('hidden');
                    btn.classList.add('flex');
                } else {
                    btn.classList.add('hidden');
                    btn.classList.remove('flex');
                }
            }
        });

        function openSpotifyModal() {
            document.getElementById('spotifyModal').classList.remove('hidden');
        }

        function closeSpotifyModal() {
            document.getElementById('spotifyModal').classList.add('hidden');
        }

        /* Currency & Number Format Helpers */
        function formatMoney(amount) {
            return parseFloat(amount || 0).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        }

        function escapeHtml(str) {
            if (!str) return '';
            return String(str)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
        }

        /* 3.1 Cart Sidebar ("View Box") Drawer Controls */
        window.openCartSidebar = function () {
            const drawer = document.getElementById('cartSidebarDrawer');
            const backdrop = document.getElementById('cartSidebarBackdrop');
            const panel = document.getElementById('cartSidebarPanel');
            if (!drawer || !panel) return;

            drawer.classList.remove('hidden');
            setTimeout(() => {
                if (backdrop) backdrop.classList.remove('opacity-0');
                panel.classList.remove('translate-x-full');
            }, 10);

            // Fetch live session box data
            fetch('/cart/sidebar-data', {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    window.renderCartSidebar(data);
                    window.updateFloatingCartBar(data.box, data.subtotal, data.cart_count);
                }
            })
            .catch(err => console.error('Error fetching sidebar data:', err));
        };

        window.closeCartSidebar = function () {
            const drawer = document.getElementById('cartSidebarDrawer');
            const backdrop = document.getElementById('cartSidebarBackdrop');
            const panel = document.getElementById('cartSidebarPanel');
            if (!drawer || !panel) return;

            if (backdrop) backdrop.classList.add('opacity-0');
            panel.classList.add('translate-x-full');

            setTimeout(() => {
                drawer.classList.add('hidden');
            }, 300);
        };

        // Close drawer on Escape key
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                window.closeCartSidebar();
            }
        });

        /* 3.2 Dynamic Cart Sidebar Renderer */
        window.renderCartSidebar = function (data) {
            if (!data) return;
            const items = data.items || [];
            const box = data.box || { total_items: 0, required_minimum: 3, is_box_full: false, remaining_items: 3, progress_percent: 0, prompt_message: '' };
            const subtotal = data.subtotal || 0;

            // 1. Update Header Title Counter
            const sidebarCountBadge = document.getElementById('sidebarItemCountBadge');
            if (sidebarCountBadge) {
                sidebarCountBadge.textContent = `${box.total_items} ${box.total_items === 1 ? 'item' : 'items'}`;
            }

            // 2. Update "Fill Your Box" Activity Tracker
            const ratioEl = document.getElementById('sidebarActivityRatio');
            if (ratioEl) ratioEl.textContent = `${box.total_items} / ${box.required_minimum} items`;

            const progBar = document.getElementById('sidebarProgressBar');
            if (progBar) {
                progBar.style.width = `${box.progress_percent}%`;
                if (box.is_box_full) {
                    progBar.className = 'h-full rounded-full transition-all duration-500 ease-out bg-emerald-500';
                } else {
                    progBar.className = 'h-full rounded-full transition-all duration-500 ease-out bg-gradient-to-r from-[#7C3AED] to-[#FACC15]';
                }
            }

            const iconEl = document.getElementById('sidebarActivityIcon');
            if (iconEl) {
                iconEl.innerHTML = box.is_box_full 
                    ? '<i class="bi bi-box2-heart-fill text-emerald-500"></i>' 
                    : '<i class="bi bi-box-seam text-amber-500"></i>';
            }

            const headingEl = document.getElementById('sidebarActivityHeading');
            if (headingEl) {
                headingEl.textContent = box.is_box_full ? 'Box Complete' : 'Fill Your Box Activity';
            }

            const msgEl = document.getElementById('sidebarActivityMessage');
            if (msgEl) {
                msgEl.innerHTML = box.is_box_full 
                    ? `<i class="bi bi-stars text-amber-500"></i> <span>${box.prompt_message}</span>`
                    : `<i class="bi bi-info-circle-fill text-grape"></i> <span>${box.prompt_message}</span>`;
            }

            // 3. Update Items List or Empty State
            const itemsContainer = document.getElementById('sidebarItemsContainer');
            const emptyState = document.getElementById('sidebarEmptyState');

            if (items.length === 0) {
                if (itemsContainer) itemsContainer.classList.add('hidden');
                if (emptyState) emptyState.classList.remove('hidden');
            } else {
                if (emptyState) emptyState.classList.add('hidden');
                if (itemsContainer) {
                    itemsContainer.classList.remove('hidden');
                    let html = '';
                    items.forEach(item => {
                        const breakdownHtml = (item.items_breakdown && item.items_breakdown.length > 0)
                            ? `<div class="text-[10px] text-slate-500 mt-1.5 flex flex-wrap gap-1">${item.items_breakdown.map(b => `<span class="inline-flex items-center gap-1 bg-lilac text-slate-600 px-1.5 py-0.5 rounded-md"><i class="bi bi-check2 text-emerald-600"></i> ${escapeHtml(b)}</span>`).join('')}</div>`
                            : '';

                        const badgeHtml = item.type === 'bundle'
                            ? `<span class="bg-sun text-ink text-[10px] font-black px-2 py-0.5 rounded-full uppercase">${escapeHtml(item.badge || 'Bundle')}</span>`
                            : (item.variation_name ? `<span class="bg-lilac text-grape text-[10px] font-bold px-2 py-0.5 rounded-full">${escapeHtml(item.variation_name)}</span>` : '');

                        const unitAddNotice = (item.type === 'bundle' && item.box_units_per_item > 1)
                            ? `<span class="text-[11px] text-grape font-semibold block">Adds ${item.box_units_per_item} items to box</span>`
                            : '';

                        html += `
                        <div class="bg-white p-3 rounded-[20px] shadow-soft flex items-center justify-between gap-3" data-item-key="${escapeHtml(item.key)}">
                            <div class="flex items-center gap-3 min-w-0">
                                <div class="w-16 h-16 bg-lilac rounded-2xl overflow-hidden flex items-center justify-center flex-shrink-0 p-1.5">
                                    <img src="${escapeHtml(item.image)}" alt="${escapeHtml(item.name)}" class="max-h-full max-w-full object-contain rounded-md" onerror="this.onerror=null; this.src='/images/products/placeholder.svg';">
                                </div>
                                <div class="min-w-0 flex-1">
                                    ${badgeHtml ? `<div class="mb-1">${badgeHtml}</div>` : ''}
                                    <h4 class="font-fun font-semibold text-ink text-[15px] truncate leading-snug" title="${escapeHtml(item.name)}">${escapeHtml(item.name)}</h4>
                                    ${unitAddNotice}
                                    ${breakdownHtml}
                                    <div class="flex items-center gap-2 mt-1">
                                        <span class="text-[13px] font-extrabold text-ink price-convertible" data-price-ngn="${item.price}">₦${formatMoney(item.price)}</span>
                                        <span class="text-[11px] text-slate-400">× ${item.quantity}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="flex flex-col items-end justify-between gap-2 flex-shrink-0">
                                <button type="button" onclick="removeCartSidebarItem('${escapeHtml(item.key)}')" class="text-slate-400 hover:text-rose-600 w-8 h-8 rounded-full hover:bg-rose-50 transition text-sm cursor-pointer flex items-center justify-center" title="Remove item">
                                    <i class="bi bi-trash3"></i>
                                </button>
                                <div class="flex items-center bg-lilac p-0.5 rounded-full text-xs font-bold">
                                    <button type="button" onclick="updateCartSidebarItemQty('${escapeHtml(item.key)}', -1)" class="w-7 h-7 rounded-full bg-white text-ink hover:bg-purple-100 transition flex items-center justify-center text-sm focus:outline-none cursor-pointer">-</button>
                                    <span class="w-7 text-center text-ink text-xs font-black sidebar-item-qty">${item.quantity}</span>
                                    <button type="button" onclick="updateCartSidebarItemQty('${escapeHtml(item.key)}', 1)" class="w-7 h-7 rounded-full bg-white text-ink hover:bg-purple-100 transition flex items-center justify-center text-sm focus:outline-none cursor-pointer">+</button>
                                </div>
                            </div>
                        </div>`;
                    });
                    itemsContainer.innerHTML = html;
                }
            }

            // 4. Update Subtotal
            const subtotalEl = document.getElementById('sidebarSubtotal');
            if (subtotalEl) {
                subtotalEl.setAttribute('data-price-ngn', subtotal);
                subtotalEl.textContent = '₦' + formatMoney(subtotal);
            }

            // 5. Update Checkout Button State
            const checkoutBtn = document.getElementById('sidebarCheckoutBtn');
            if (checkoutBtn) {
                if (box.is_box_full) {
                    checkoutBtn.className = 'bg-ink hover:bg-inkdeep text-white font-bold h-12 rounded-full text-[13px] flex items-center justify-center gap-1.5 transition cursor-pointer';
                    checkoutBtn.setAttribute('href', '{{ route('checkout.show') }}');
                    checkoutBtn.innerHTML = '<span>Checkout</span><i class="bi bi-arrow-right text-sm"></i>';
                    checkoutBtn.onclick = null;
                } else {
                    checkoutBtn.className = 'bg-slate-200 text-slate-500 font-bold h-12 rounded-full text-[13px] flex items-center justify-center gap-1.5 transition cursor-pointer';
                    checkoutBtn.setAttribute('href', 'javascript:void(0)');
                    checkoutBtn.innerHTML = '<span>Checkout</span><i class="bi bi-lock-fill text-xs"></i>';
                    checkoutBtn.onclick = function () {
                        showToastNotification(`Add ${box.remaining_items} more ${box.remaining_items === 1 ? 'item' : 'items'} to fill your box before checkout!`);
                    };
                }
            }

            // 6. Update Currency
            const curr = sessionStorage.getItem('selected_currency') || 'NGN';
            changeCurrency(curr);
        };

        /* 3.3 Sidebar Item Quantity & Remove Handlers */
        window.updateCartSidebarItemQty = function (key, delta) {
            const itemEl = document.querySelector(`[data-item-key="${key}"]`);
            let currentQty = 1;
            if (itemEl) {
                const qtySpan = itemEl.querySelector('.sidebar-item-qty');
                if (qtySpan) currentQty = parseInt(qtySpan.textContent) || 1;
            }
            const newQty = currentQty + delta;

            fetch(`/cart/update/${encodeURIComponent(key)}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ quantity: newQty })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    window.renderCartSidebar(data);
                    window.updateFloatingCartBar(data.box, data.subtotal, data.cart_count);
                    showToastNotification(data.message || 'Box updated');
                }
            })
            .catch(err => console.error(err));
        };

        window.removeCartSidebarItem = function (key) {
            fetch(`/cart/remove/${encodeURIComponent(key)}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    window.renderCartSidebar(data);
                    window.updateFloatingCartBar(data.box, data.subtotal, data.cart_count);
                    showToastNotification(data.message || 'Item removed from your box');
                }
            })
            .catch(err => console.error(err));
        };

        /* 3.4 Floating Cart Bar Dynamic Update Helper */
        window.updateFloatingCartBar = function (box, subtotal, cartCount) {
            const totalItems = (box && typeof box.total_items !== 'undefined') ? box.total_items : (cartCount || 0);

            // Update Top Header Counter Badge
            const headerBadge = document.getElementById('cartCountBadge');
            if (headerBadge) headerBadge.textContent = totalItems;

            // Update Top Header Activity Tag
            const headerTag = document.getElementById('headerBoxActivityTag');
            if (headerTag && box) {
                if (totalItems > 0 && !box.is_box_full) {
                    headerTag.innerHTML = `<span class="hidden md:inline text-[10px] bg-amber-400/20 text-amber-200 px-1.5 py-0.5 rounded-md font-extrabold">${box.remaining_items} more</span>`;
                } else if (box.is_box_full) {
                    headerTag.innerHTML = `<span class="hidden md:inline text-[10px] bg-emerald-400/20 text-emerald-300 px-1.5 py-0.5 rounded-md font-extrabold">Box Full</span>`;
                } else {
                    headerTag.innerHTML = '';
                }
            }

            // Update Floating Cart Bar
            const bar = document.getElementById('floatingCartBar');
            if (bar) {
                if (totalItems > 0) {
                    bar.classList.remove('hidden');
                    const countEl = document.getElementById('floatingCartItemCount');
                    const labelEl = document.getElementById('floatingCartItemLabel');
                    const subtotalEl = document.getElementById('floatingCartSubtotal');
                    const actBadge = document.getElementById('floatingCartActivityBadge');

                    if (countEl) countEl.textContent = totalItems;
                    if (labelEl) labelEl.textContent = totalItems === 1 ? 'Item' : 'Items';
                    if (subtotalEl && typeof subtotal !== 'undefined') {
                        subtotalEl.setAttribute('data-price-ngn', subtotal);
                        subtotalEl.textContent = '₦' + formatMoney(subtotal);
                    }

                    if (actBadge && box) {
                        if (box.is_box_full) {
                            actBadge.className = 'text-[9px] font-black px-1.5 py-0.5 rounded-md leading-none bg-emerald-400/25 text-emerald-300';
                            actBadge.textContent = 'Box Full';
                        } else {
                            actBadge.className = 'text-[9px] font-black px-1.5 py-0.5 rounded-md leading-none bg-amber-400/20 text-amber-300';
                            actBadge.textContent = `${box.remaining_items} more to fill`;
                        }
                    }

                    const curr = sessionStorage.getItem('selected_currency') || 'NGN';
                    changeCurrency(curr);
                } else {
                    bar.classList.add('hidden');
                }
            }
        };

        /* Nourishark-Style Quick Add Product Modal Logic */
        let currentModalProduct = null;
        let currentModalQty = 1;

        function triggerQuickAddFromBtn(btn) {
            const product = {
                id: btn.getAttribute('data-id'),
                name: btn.getAttribute('data-name'),
                price: btn.getAttribute('data-price'),
                sale_price: btn.getAttribute('data-saleprice') || null,
                stock_quantity: parseInt(btn.getAttribute('data-stock') || 0),
                description: btn.getAttribute('data-desc'),
                category_name: btn.getAttribute('data-category'),
                image: btn.getAttribute('data-image') || null
            };
            openQuickAddModal(product);
        }

        function openQuickAddModal(product) {
            currentModalProduct = product;
            currentModalQty = 1;

            document.getElementById('quickAddTitle').textContent = product.name;
            document.getElementById('quickAddCategory').textContent = product.category_name || 'Book';
            document.getElementById('quickAddDescription').textContent = product.description || '';
            const stockBadge = document.getElementById('quickAddStock');
            if (product.stock_quantity > 0) {
                stockBadge.textContent = 'In Stock';
                stockBadge.className = 'bg-mint text-emerald-700 text-[11px] font-bold px-2.5 py-1 rounded-full uppercase';
            } else {
                stockBadge.textContent = 'Out of Stock';
                stockBadge.className = 'bg-rose-50 text-rose-700 text-[11px] font-bold px-2.5 py-1 rounded-full uppercase';
            }
            
            const imageEl = document.getElementById('quickAddImage');
            if (product.image) {
                if (product.image.startsWith('http://') || product.image.startsWith('https://') || product.image.startsWith('/')) {
                    imageEl.src = product.image;
                } else {
                    imageEl.src = '/storage/' + product.image;
                }
                imageEl.classList.remove('hidden');
                document.getElementById('quickAddPlaceholderIcon').classList.add('hidden');
            } else {
                imageEl.classList.add('hidden');
                document.getElementById('quickAddPlaceholderIcon').classList.remove('hidden');
            }

            updateModalPriceAndQtyDisplay();
            document.getElementById('quickAddModal').classList.remove('hidden');
        }

        function closeQuickAddModal() {
            document.getElementById('quickAddModal').classList.add('hidden');
        }

        function changeModalQty(delta) {
            const newQty = currentModalQty + delta;
            if (newQty >= 1 && newQty <= (currentModalProduct?.stock_quantity || 99)) {
                currentModalQty = newQty;
                updateModalPriceAndQtyDisplay();
            }
        }

        function updateModalPriceAndQtyDisplay() {
            document.getElementById('quickAddQtyDisplay').textContent = currentModalQty;
            const unitPrice = parseFloat(currentModalProduct.sale_price || currentModalProduct.price);
            const totalPrice = unitPrice * currentModalQty;
            
            const btnPriceEl = document.getElementById('quickAddBtnPriceDisplay');
            btnPriceEl.setAttribute('data-price-ngn', totalPrice);
            
            const curr = sessionStorage.getItem('selected_currency') || 'NGN';
            changeCurrency(curr);
        }

        function submitQuickAddModal() {
            if (!currentModalProduct) return;

            const submitBtn = document.getElementById('quickAddSubmitBtn');
            const originalHtml = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="bi bi-arrow-repeat animate-spin mr-1"></i> Adding...';

            fetch(`/cart/add/${currentModalProduct.id}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    quantity: currentModalQty
                })
            })
            .then(res => res.json())
            .then(data => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalHtml;
                if (data.success) {
                    window.updateFloatingCartBar(data.box, data.subtotal, data.cart_count);
                    window.renderCartSidebar(data);
                    closeQuickAddModal();
                    showToastNotification(data.message || 'Item added to your box!');
                }
            })
            .catch(err => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalHtml;
                console.error(err);
            });
        }

        function showToastNotification(msg) {
            const toast = document.getElementById('toastNotification');
            document.getElementById('toastMessage').textContent = msg;
            toast.classList.remove('hidden');
            setTimeout(() => {
                toast.classList.add('hidden');
            }, 3000);
        }

        window.addEventListener('DOMContentLoaded', () => {
            const saved = sessionStorage.getItem('selected_currency') || 'NGN';
            const currencySelector = document.getElementById('currencySelector');
            if (currencySelector) currencySelector.value = saved;
            changeCurrency(saved);
        });
    </script>
</body>
</html>
