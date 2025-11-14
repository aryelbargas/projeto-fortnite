<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserCosmetic extends Model
{
    public $timestamps = false;
    protected $fillable = [
        "user_id",
        "cosmetic_id"
    ];
}
