<?php

namespace App\Services;

use App\Utils\FortniteAPIUtil;

use App\Repositories\CosmeticRepository;
use App\Repositories\VBuckBallanceRepository;

use \Exception;

class CosmeticService
{

    public function __construct(
        private FortniteAPIUtil $fortniteAPIUtil,
        private CosmeticRepository $cosmeticRepository,
        private VBuckBallanceRepository $vBuckBallanceRepository
    ) {}

    public function list(?int $userId = null) 
    {
        $cosmetics = $this->cosmeticRepository->list()->toArray();

        if($userId == null) {
            return $cosmetics;
        }

        $cosmetics['data'] = $this->verifyOwnedCosmetics($userId, $cosmetics["data"]);

        return $cosmetics;
    }

    public function syncAllCosmetics()
    {
        $apiCosmetics = $this->fortniteAPIUtil->fetchAllCosmetics();
        $shopItems = $this->fortniteAPIUtil->fetchAllShopItems();

        $apiCosmetics = array_merge($apiCosmetics["br"], $apiCosmetics["instruments"], $apiCosmetics["cars"]);

        foreach ($apiCosmetics as $apiCosmetic) {
            $prices = $this->searchForCosmeticPrice($apiCosmetic["id"], $shopItems);

            $dataToInsert = [
                "name" => $apiCosmetic["name"],
                "description" => $apiCosmetic["description"],
                "added" => $this->formatDate($apiCosmetic["added"]),
                "store_id" => $apiCosmetic["id"],
                "image" => $this->getItemImage($apiCosmetic),
                "type" => $apiCosmetic["type"]["value"] ?? "unknow",
                "rarity" => $apiCosmetic["rarity"]["value"] ?? "unknow",
                "price" => $prices["price"],
                "final_price" => $prices["final_price"],
            ];

            $this->cosmeticRepository->updateOrCreate($dataToInsert);
        }
    }

    private function formatDate(string $date): string
    {
        $date = str_replace("T", " ", $date);
        $date = str_replace("Z", "", $date);

        return $date;
    }

    private function searchForCosmeticPrice(string $storeId, array $shopItems): ?array
    {
        foreach ($shopItems as $shopItem) {
            if(
                array_key_exists("cars", $shopItem) &&
                count($shopItem["cars"]) == 1
                ) {
                foreach ($shopItem["cars"] as $car) {
                    if($car["id"] == $storeId) {
                        return [
                            "price" => $shopItem["regularPrice"],
                            "final_price" => $shopItem["finalPrice"]
                        ];
                    }
                }
            }

            if(
                array_key_exists("brItems", $shopItem) &&
                count($shopItem["brItems"]) == 1 &&
                $shopItem["brItems"][0]["id"] == $storeId
            ) {
                return [
                    "price" => $shopItem["regularPrice"],
                    "final_price" => $shopItem["finalPrice"]
                ];
            }
        }

        return [
            "price" => null,
            "final_price" =>null
        ];
    }

    function getItemImage(array $apiCosmetic): string
    {
        if(!array_key_exists("images", $apiCosmetic)) {
            return "";
        }

        $images = $apiCosmetic["images"];

        if(array_key_exists("large", $images)) {
            return $images["large"];
        }

        if(array_key_exists("small", $images)) {
            return $images["small"];
        }

        if(array_key_exists("icon", $images)) {
            return $images["icon"];
        }

        if(array_key_exists("smallIcon", $images)) {
            return $images["smallIcon"];
        }

        return "";
    }

    public function listComesticsByUserID(int $userId)
    {
        $cosmetics = $this->cosmeticRepository->listComesticsByUserID($userId)->toArray();
        
        $cosmetics['data'] = $this->verifyOwnedCosmetics($userId, $cosmetics['data']);

        return $cosmetics;
    }

    public function addCosmeticToUser(int $cosmeticId, int $userId)
    {
        if($this->cosmeticRepository->isCosmeticOwnedByUser($cosmeticId, $userId)) {
            $this->removeCosmeticFromUser($cosmeticId, $userId);
            return;
        }

        $userVBucks = $this->vBuckBallanceRepository->userTotalVBucks($userId);
        $cosmetic = $this->cosmeticRepository->getById($cosmeticId);

        if($cosmetic->final_price > $userVBucks) {
            throw new Exception("Saldo insuficiente.");
        }

        $this->cosmeticRepository->addCosmeticToUser($cosmeticId, $userId);
        $this->vBuckBallanceRepository->create(
            [
                "value" => -$cosmetic->final_price,
                "description" => 'Comprou o cosmetico "' . $cosmetic->name . '".',
                "user_id" => $userId,
                "cosmetic_id" => $cosmeticId
            ]
        );
    }

    public function removeCosmeticFromUser(int $cosmeticId, int $userId)
    {
        if(!$this->cosmeticRepository->isCosmeticOwnedByUser($cosmeticId, $userId)) {
            return;
        }

        $cosmetic = $this->cosmeticRepository->getById($cosmeticId);

        $this->cosmeticRepository->removeCosmeticFromUser($cosmeticId, $userId);
        $this->vBuckBallanceRepository->create(
            [
                "value" => $cosmetic->final_price,
                "description" => 'Devolveu o cosmetico "' . $cosmetic->name . '".',
                "user_id" => $userId,
                "cosmetic_id" => $cosmeticId
            ]
        );
    }

    public function verifyOwnedCosmetics(int $userId, array $cosmetics): array
    {
        $ownedCosmetics = [];

        foreach ($cosmetics as $cosmetic) {
            $cosmetic['owned'] = $this->cosmeticRepository->isCosmeticOwnedByUser($cosmetic['id'], $userId);
            $ownedCosmetics[] = $cosmetic;
        }

        return $ownedCosmetics;
    }
}