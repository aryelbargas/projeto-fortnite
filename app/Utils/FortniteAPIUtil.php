<?php

namespace App\Utils;

use Illuminate\Support\Facades\Http;

class FortniteAPIUtil
{
    public function fetchAllCosmetics(): array
    {
        return Http::get(ENV("API_FORTNITE_URL") . "/v2/cosmetics")->json('data');
    }

    public function fetchAllShopItems(): array
    {
        return Http::get(ENV("API_FORTNITE_URL") . "/v2/shop")->json('data.entries');
    }
}