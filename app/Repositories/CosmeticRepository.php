<?php

namespace App\Repositories;
use App\Models\Cosmetic;

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
}
