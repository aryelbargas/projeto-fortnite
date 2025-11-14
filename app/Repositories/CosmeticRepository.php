<?php

namespace App\Repositories;
use App\Models\Cosmetic;
use App\Models\UserCosmetic;

class CosmeticRepository
{
    public function create(array $data): Cosmetic
    {
        return Cosmetic::create($data);
    }

    public function update(Cosmetic $cosmetic, array $data): bool
    {
        return $cosmetic->update($data);
    }

    public function getById(string $cosmeticId): ?Cosmetic
    {
        return Cosmetic::find($cosmeticId);
    }

    public function getByStoreId(string $storeId): ?Cosmetic
    {
        return Cosmetic::where("store_id", $storeId)->first();
    }

    public function updateOrCreate(array $data): Cosmetic
    {
        $cosmetic = $this->getByStoreId($data['store_id']);

        if($cosmetic != null) {
            $this->update($cosmetic, $data);
            
            return $cosmetic;
        }

        return $this->create($data);
    }

    public function list()
    {
        return Cosmetic::orderBy("price", "DESC")->orderBy("id", "DESC")->paginate();
    }

    public function listComesticsByUserID($userId)
    {
        return Cosmetic::select("cosmetics.*")
            ->leftJoin('user_cosmetics', 'cosmetics.id', 'cosmetic_id')
            ->where("user_id", $userId)
            ->paginate();
    }

    public function addCosmeticToUser(int $cosmeticId, int $userId): UserCosmetic
    {
        return UserCosmetic::create([
            "cosmetic_id" => $cosmeticId,
            "user_id" => $userId
        ]);
    }

    public function removeCosmeticFromUser(int $cosmeticId, int $userId)
    {
        return UserCosmetic::where([
            'user_id' => $userId,
            'cosmetic_id' => $cosmeticId
        ])->delete();
    }

    public function isCosmeticOwnedByUser(int $cosmeticId, int $userId): bool
    {
        return UserCosmetic::where([
            'user_id' => $userId,
            'cosmetic_id' => $cosmeticId
        ])->count() > 0;
    }
}
