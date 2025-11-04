<?php

namespace App\Repositories;
use App\Models\Cosmetic;

class CosmeticRepository
{
    public function create(array $data): Cosmetic
    {
        return Cosmetic::create($data);
    }
}
