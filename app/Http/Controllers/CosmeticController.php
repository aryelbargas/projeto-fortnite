<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\CosmeticService;

class CosmeticController extends Controller
{
    public function __construct(private CosmeticService $cosmeticService) {}

    public function syncAllCosmetics()
    {
        $this->cosmeticService->syncAllCosmetics();
    }

    public function list()
    {
        return $this->cosmeticService->list();
    }
}
