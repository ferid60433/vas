<?php

if (!function_exists('lookup')) {
    function lookup(string $key): ?string
    {
        return Vas\Lookup::all()
            ->pluck('value', 'key')
            ->get($key);
    }
}
