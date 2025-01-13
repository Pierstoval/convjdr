<?php

declare(strict_types=1);

namespace App\Util;

final readonly class Urlizer
{
    public static function urlize(string $string): string
    {
        if (!$string) {
            return '';
        }

        $encoding = \mb_detect_encoding($string, \mb_detect_order(), true);

        return $encoding
            ? \mb_convert_case($string, \MB_CASE_LOWER, $encoding)
            : \mb_convert_case($string, \MB_CASE_LOWER);
    }
}
