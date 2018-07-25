<?php

namespace Vas\Util;

use Illuminate\Support\Str;

class GsmEncoding
{
    public static function is_gsm0338(string $utf8_string): bool
    {
        $gsm0338 = array(
            '@', 'Δ', ' ', '0', '¡', 'P', '¿', 'p', //
            '£', '_', '!', '1', 'A', 'Q', 'a', 'q', //
            '$', 'Φ', '"', '2', 'B', 'R', 'b', 'r', //
            '¥', 'Γ', '#', '3', 'C', 'S', 'c', 's', //
            'è', 'Λ', '¤', '4', 'D', 'T', 'd', 't', //
            'é', 'Ω', '%', '5', 'E', 'U', 'e', 'u', //
            'ù', 'Π', '&', '6', 'F', 'V', 'f', 'v', //
            'ì', 'Ψ', '\'', '7', 'G', 'W', 'g', 'w', //
            'ò', 'Σ', '(', '8', 'H', 'X', 'h', 'x', //
            'Ç', 'Θ', ')', '9', 'I', 'Y', 'i', 'y', //
            "\n", 'Ξ', '*', ':', 'J', 'Z', 'j', 'z', //
            'Ø', "\x1B", '+', ';', 'K', 'Ä', 'k', 'ä', //
            'ø', 'Æ', ',', '<', 'L', 'Ö', 'l', 'ö', //
            "\r", 'æ', '-', '=', 'M', 'Ñ', 'm', 'ñ', //
            'Å', 'ß', '.', '>', 'N', 'Ü', 'n', 'ü', //
            'å', 'É', '/', '?', 'O', '§', 'o', 'à', //
        );

        $len = Str::length($utf8_string, 'UTF-8');

        for ($i = 0; $i < $len; $i++) {
            $ch = Str::substr($utf8_string, $i, 1);

            if (!in_array($ch, $gsm0338, true)) {
                return false;
            }
        }

        return true;
    }
    
}
