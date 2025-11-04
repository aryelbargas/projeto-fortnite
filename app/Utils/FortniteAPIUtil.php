<?php

namespace App\Utils;

use Illuminate\Support\Facades\Http;

class FortniteAPIUtil
{
    public function fetchAllCosmetics(): array
    {
        return Http::get("https://fortnite-api.com/v2/cosmetics/br")->json('data');
    }
}