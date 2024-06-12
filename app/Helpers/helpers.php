<?php

use Illuminate\Support\Str;

if (!function_exists('generateUniqueToken')) {
    function generateUniqueToken($postId)
    {
        return hash('sha256', $postId . Str::random(40));
    }
}
