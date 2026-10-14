<?php

namespace App\Support;

class Phone
{
    /**
     * Samakan semua penulisan ke format 08xxxxxxxxxx.
     * +62 812..., 62812..., 812..., dan 0812... semuanya jadi 0812...
     */
    public static function normalize(string $value): string
    {
        $digits = preg_replace('/\D+/', '', $value) ?? '';

        if (str_starts_with($digits, '62')) {
            return '0'.substr($digits, 2);
        }

        if (str_starts_with($digits, '8')) {
            return '0'.$digits;
        }

        return $digits;
    }
}
