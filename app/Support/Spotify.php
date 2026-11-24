<?php

namespace App\Support;

class Spotify
{
    public static function showUrl(): ?string
    {
        return config('services.spotify.show_url') ?: null;
    }

    public static function episodeUrl(): ?string
    {
        return config('services.spotify.episode_url') ?: null;
    }

    /**
     * Link used by "Listen on Spotify" buttons: the show, else the episode, else Spotify itself.
     */
    public static function listenUrl(): string
    {
        return self::showUrl() ?? self::episodeUrl() ?? 'https://open.spotify.com';
    }

    /**
     * Turn an open.spotify.com share link (show / episode / playlist / album / track)
     * into its official embed URL. Returns null when the link is not a Spotify link.
     */
    public static function embedUrl(?string $url): ?string
    {
        if (! $url) {
            return null;
        }

        if (preg_match('~open\.spotify\.com/(?:intl-[a-z-]+/)?(?:embed/)?(show|episode|playlist|album|track)/([A-Za-z0-9]+)~', $url, $m)) {
            return "https://open.spotify.com/embed/{$m[1]}/{$m[2]}?utm_source=generator";
        }

        return null;
    }
}
