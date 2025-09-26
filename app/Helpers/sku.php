<?php

use Illuminate\Support\Str;

if (!function_exists('generateSku')) {
    function generateSku(string $prefix = 'PROD'): string
    {
        $date = now()->format('Ymd'); // Ngày
        $random = strtoupper(Str::random(6)); // 6 ký tự random
        return "{$prefix}-{$date}-{$random}";
    }
}
