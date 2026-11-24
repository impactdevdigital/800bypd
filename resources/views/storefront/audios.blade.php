@extends('layouts.app')

@section('content')
@php
    $listenUrl = \App\Support\Spotify::listenUrl();
    $hasShow = (bool) \App\Support\Spotify::embedUrl(\App\Support\Spotify::showUrl());
    $hasEpisode = (bool) \App\Support\Spotify::embedUrl(\App\Support\Spotify::episodeUrl());
@endphp

<!-- Header Banner with featured episode -->
<section class="relative rounded-[28px] sm:rounded-[40px] bg-inkdeep text-white overflow-hidden mb-12 sm:mb-16">
    <div class="absolute -right-24 -top-24 w-[420px] h-[420px] rounded-full bg-grape/40 blur-3xl"></div>
    <div class="absolute -left-20 -bottom-24 w-72 h-72 rounded-full bg-[#1DB954]/20 blur-3xl"></div>
    <div class="relative grid lg:grid-cols-12 gap-8 items-center p-6 sm:p-12">
        <div class="lg:col-span-6">
            <span class="inline-flex items-center gap-2 bg-sun text-ink font-bold text-[11px] uppercase tracking-[.14em] px-3.5 py-1.5 rounded-full mb-5">
                <i class="bi bi-spotify"></i> Spotify Audio Channel
            </span>
            <h1 class="font-fun text-[34px] sm:text-[50px] font-semibold leading-[1.05] mb-4">Affirmations, Bedtime Stories & Audiobooks</h1>
            <p class="text-indigo-200 text-[15px] sm:text-[17px] leading-relaxed mb-8 max-w-lg">
                Immerse children in soothing storytelling and truths narrated by <strong class="text-white">PD</strong>. Stream directly on Spotify or listen below!
            </p>
            <div class="flex flex-col sm:flex-row gap-3">
                <button onclick="openSpotifyModal()" class="h-14 px-7 bg-sun hover:bg-yellow-300 text-ink font-bold rounded-full text-[14px] transition flex items-center justify-center gap-2">
                    <i class="bi bi-play-circle-fill text-lg text-grape"></i> Open Player Widget
                </button>
                <a href="{{ $listenUrl }}" target="_blank" rel="noopener" class="h-14 px-7 bg-white/10 hover:bg-white/20 border border-white/20 text-white font-bold rounded-full text-[14px] transition flex items-center justify-center gap-2">
                    Launch Spotify App <i class="bi bi-box-arrow-up-right text-xs"></i>
                </a>
            </div>
        </div>
        <div class="lg:col-span-6">
            <div class="bg-white/5 border border-white/10 rounded-[24px] p-3 sm:p-4 backdrop-blur">
                <x-spotify-player height="352" />
            </div>
        </div>
    </div>
</section>

@if($hasShow && $hasEpisode)
    <!-- Full show -->
    <section class="mb-12 sm:mb-16">
        <div class="flex items-end justify-between mb-6">
            <div>
                <p class="eyebrow mb-2">Spotify Audio Channel</p>
                <h2 class="font-fun font-semibold text-[28px] sm:text-[36px] text-ink leading-tight">Bedtime Stories</h2>
                <p class="text-[14px] text-slate-500 mt-1">Narrated by PD</p>
            </div>
        </div>
        <x-spotify-player type="show" height="352" class="shadow-soft" />
    </section>
@endif

<!-- Audio Episodes (hidden when empty and the Spotify show player is already shown above) -->
@if($audios->isNotEmpty() || ! ($hasShow && $hasEpisode))
<section class="mb-6">
    <div class="mb-6">
        <p class="eyebrow mb-2">Audio Episodes</p>
        <h2 class="font-fun font-semibold text-[28px] sm:text-[36px] text-ink leading-tight">Listen & Learn</h2>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        @forelse($audios as $audio)
            @php
                $audioEmbed = \App\Support\Spotify::embedUrl($audio->specifications['spotify_url'] ?? null);
                $audioLink = $audio->specifications['spotify_url'] ?? $listenUrl;
            @endphp
            <div class="bg-white rounded-[24px] p-4 sm:p-5 shadow-soft flex flex-col gap-4">
                <div class="flex flex-col sm:flex-row gap-5 sm:items-center">
                    <div class="w-full sm:w-36 h-36 rounded-[18px] overflow-hidden bg-ink flex-shrink-0 relative flex items-center justify-center">
                        @if($audio->primaryImage)
                            <img src="{{ $audio->card_image_url }}" alt="{{ $audio->name }}" class="w-full h-full object-cover">
                        @else
                            <i class="bi bi-music-note-beamed text-5xl text-sun"></i>
                        @endif
                        <span class="absolute bottom-2 right-2 bg-sun text-ink text-[10px] font-bold px-2 py-0.5 rounded-full">{{ $audio->specifications['duration'] ?? '15 mins' }}</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <span class="text-[11px] font-bold text-grape uppercase tracking-wider">Narrated by {{ $audio->specifications['narrator'] ?? 'WrittenbyPD' }}</span>
                        <h3 class="font-fun font-semibold text-ink text-[22px] leading-tight mt-1 mb-2">{{ $audio->name }}</h3>
                        <p class="text-[13px] text-slate-500 line-clamp-2 leading-relaxed mb-4">{{ $audio->description }}</p>
                        <div class="flex items-center gap-2">
                            <button onclick="openSpotifyModal()" class="h-10 px-4 bg-ink hover:bg-inkdeep text-white font-bold text-[13px] rounded-full flex items-center gap-1.5 transition">
                                <i class="bi bi-play-fill text-base text-sun"></i> Listen Now
                            </button>
                            <a href="{{ $audioLink }}" target="_blank" rel="noopener" class="h-10 px-4 bg-lilac hover:bg-purple-100 text-grape font-bold text-[13px] rounded-full transition flex items-center gap-1.5">
                                <i class="bi bi-spotify"></i> Spotify
                            </a>
                        </div>
                    </div>
                </div>
                @if($audioEmbed)
                    <iframe class="w-full rounded-[14px] border-0" src="{{ $audioEmbed }}" height="152" loading="lazy" title="{{ $audio->name }} on Spotify" allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture"></iframe>
                @endif
            </div>
        @empty
            <div class="col-span-full py-12 text-center bg-white rounded-[24px] shadow-soft p-6">
                <div class="w-16 h-16 rounded-2xl bg-[#1DB954] text-white flex items-center justify-center text-3xl mx-auto mb-4"><i class="bi bi-spotify"></i></div>
                <p class="font-bold text-[14px] text-ink mb-5">No audio episodes available yet.</p>
                <a href="{{ $listenUrl }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 bg-[#1DB954] hover:bg-emerald-600 text-white text-[13px] font-bold px-6 h-12 rounded-full transition">
                    <i class="bi bi-spotify"></i> Listen on Spotify
                </a>
            </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $audios->links() }}
    </div>
</section>
@endif

@endsection
