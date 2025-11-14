<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Services\CosmeticService;

use App\Http\Requests\AddCosmeticToUserRequest;

class CosmeticController extends Controller
{
    public function __construct(private CosmeticService $cosmeticService) {}

    public function syncAllCosmetics()
    {
        $this->cosmeticService->syncAllCosmetics();
    }

    public function list()
    {
        $userId = null;

        if(Auth::user() != null)
        {
            $userId = Auth::user()->id;
        }

        return $this->cosmeticService->list($userId);
    }

    public function listComesticsByUserID()
    {
        return $this->cosmeticService->listComesticsByUserID(Auth::user()->id);
    }

    public function addCosmeticToUser(AddCosmeticToUserRequest $request)
    {
        return $this->cosmeticService->addCosmeticToUser($request->get('cosmetic_id'), Auth::user()->id);
    }
}
