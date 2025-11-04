<?php

namespace App\Services;

use App\Utils\FortniteAPIUtil;

use App\Repositories\CosmeticRepository;

class CosmeticService
{

    public function __construct(
        private FortniteAPIUtil $fortniteAPIUtil,
        private CosmeticRepository $cosmeticRepository
    ) {}

    public function syncAllCosmetics()
    {
        $apiCosmetics = $this->fortniteAPIUtil->fetchAllCosmetics();

        foreach ($apiCosmetics as $apiCosmetic) {
            $dataToInsert = [
                "name" => $apiCosmetic["name"],
                "description" => $apiCosmetic["description"],
                "added" => $this->formatDate($apiCosmetic["added"]),
                "store_id" => $apiCosmetic["id"],
                "image" => ""
            ];

            $this->cosmeticRepository->create($dataToInsert);
        }
    }

    private function formatDate(string $date): string
    {
        $date = str_replace("T", " ", $date);
        $date = str_replace("Z", "", $date);

        return $date;
    }
}