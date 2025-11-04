<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cosmetic extends Model
{
    public $timestamps = false;
    protected $fillable = [
        "name",
        "description",
        "store_id",
        "image",
        "added",
        "price",
        "final_price",
        "rarity_id",
        "type_id"
    ];
}
