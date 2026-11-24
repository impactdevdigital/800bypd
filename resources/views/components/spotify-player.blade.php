@props(['type' => 'episode', 'height' => 232])
@php
    $sourceUrl = $type === 'show' ? \App\Support\Spotify::showUrl() : (\App\Support\Spotify::episodeUrl() ?? \App\Support\Spotify::showUrl());
    $embedUrl = \App\Support\Spotify::embedUrl($sourceUrl);
@endphp

@if($embedUrl)
    <iframe {{ $attributes->merge(['class' => 'w-full rounded-[18px] border-0 block']) }}
            src="{{ $embedUrl }}"
            height="{{ $height }}"
            loading="lazy"
            title="800BYPD on Spotify"
            allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture"></iframe>
@else
    <div {{ $attributes->merge(['class' => 'w-full rounded-[18px] bg-white/10 border border-white/15 p-5 flex flex-wrap items-center gap-4']) }}>
        <span class="w-12 h-12 rounded-full bg-[#1DB954] text-white flex items-center justify-center text-2xl flex-shrink-0"><i class="bi bi-spotify"></i></span>
        <div class="min-w-[180px] flex-1">
            <p class="font-bold text-sm">Spotify Audio Channel</p>
            <p class="text-xs opacity-70">Listen to bedtime story audiobooks and podcasts narrated by PD.</p>
        </div>
        <a href="{{ \App\Support\Spotify::listenUrl() }}" target="_blank" rel="noopener" class="h-10 px-4 rounded-full bg-[#1DB954] text-white text-xs font-bold flex items-center justify-center gap-1.5 flex-shrink-0 max-sm:w-full">Open Spotify App <i class="bi bi-box-arrow-up-right"></i></a>
    </div>
@endif
