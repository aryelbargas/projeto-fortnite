<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VBuckBallance extends Model
{
    protected $table = "vbuck_ballance";
    protected $fillable = [
        "value",
        "description",
        "user_id",
        "cosmetic_id"
    ];
}
