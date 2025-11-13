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

    public function list() 
    {
        return $this->cosmeticRepository->list();
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
}