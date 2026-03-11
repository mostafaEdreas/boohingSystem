<?php
use Illuminate\Http\Request;

if (!function_exists('getRequestValuesAsString')) {
    function getRequestValuesAsString(Request $request, string $prefix = 'hotels'): string
    {
        // 1. Get the current "Version" of the hotel data
        // If you update a hotel, run: Cache::increment('hotels_version');
        $version = cache()->get("{$prefix}_version", 1);

        $data = $request->except($request->allFiles());

        // 2. Normalize values to lowercase (optional but recommended)
        $data = array_map(function($value) {
            return is_string($value) ? strtolower(trim($value)) : $value;
        }, $data);

        // 3. Sort keys alphabetically
        ksort($data);

        // 4. Return a key that includes the version
        // Result: "hotels_v1_abcd1234..."
        return "{$prefix}_v{$version}_" . md5(json_encode($data));
    }
}