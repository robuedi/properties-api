<?php

namespace App\Services;

use Illuminate\Support\Str;

class TextUniqueSlugService 
{
    public function getSlug(string $text) : string
    {
        // get current time in milliseconds
        $milliseconds = round(microtime(true) * 1000);

        return Str::slug($text.'-'.base_convert($milliseconds, 10, 36));
    }
}
