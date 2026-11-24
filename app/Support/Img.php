<?php

namespace App\Support;

/**
 * Serves web-sized copies of product images when they exist.
 *
 * public/images/products/sm/  ~640px wide  (cards, thumbnails, menus)
 * public/images/products/lg/  ~1400px wide (hero, product page)
 *
 * Falls back to the original file/URL when no resized copy exists
 * (for example images uploaded later through the admin panel).
 */
class Img
{
    public static function sm(?string $pathOrUrl): string
    {
        return self::variant($pathOrUrl, 'sm');
    }

    public static function lg(?string $pathOrUrl): string
    {
        return self::variant($pathOrUrl, 'lg');
    }

    protected static function variant(?string $pathOrUrl, string $size): string
    {
        if (! $pathOrUrl) {
            return asset('images/products/placeholder.svg');
        }

        $basename = basename(parse_url($pathOrUrl, PHP_URL_PATH) ?: $pathOrUrl);

        if (str_ends_with(strtolower($basename), '.jpg') && file_exists(public_path("images/products/{$size}/{$basename}"))) {
            return asset("images/products/{$size}/{$basename}");
        }

        if (str_starts_with($pathOrUrl, 'http://') || str_starts_with($pathOrUrl, 'https://') || str_starts_with($pathOrUrl, '/')) {
            return $pathOrUrl;
        }

        return asset('images/products/' . $basename);
    }
}
