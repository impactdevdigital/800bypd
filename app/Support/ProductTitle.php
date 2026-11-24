<?php

namespace App\Support;

class ProductTitle
{
    /**
     * Split "Give Thanks (Psalm 107:1) Jigsaw Puzzle" into
     * ['Give Thanks Jigsaw Puzzle', 'Psalm 107:1'].
     */
    public static function split(string $name): array
    {
        $open = strpos($name, '(');
        $close = $open !== false ? strpos($name, ')', $open) : false;

        if ($open === false || $close === false) {
            return [trim($name), null];
        }

        $title = trim(trim(substr($name, 0, $open)) . ' ' . trim(substr($name, $close + 1)));
        $reference = trim(substr($name, $open + 1, $close - $open - 1));

        return [$title, $reference !== '' ? $reference : null];
    }
}
