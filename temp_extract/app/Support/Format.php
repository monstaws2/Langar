<?php

namespace App\Support;

class Format
{
    /**
     * Convert any string/number's ASCII digits to Persian digits.
     */
    public static function digits($value): string
    {
        $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $english = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

        return str_replace($english, $persian, (string) $value);
    }

    /**
     * Format a price with thousands separators and Persian digits.
     * e.g. 125000 => "۱۲۵٬۰۰۰"
     */
    public static function price($value): string
    {
        return self::digits(number_format((float) $value));
    }
}
