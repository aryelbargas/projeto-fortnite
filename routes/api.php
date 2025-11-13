<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CosmeticController;

Route::get('/', function (Request $request) {
    return "API Fortnite";
});

Route::prefix('/cosmetics')->controller(CosmeticController::class)->group(function () {
    Route::get('/', 'list');
    Route::get('/sync', 'syncAllCosmetics');
});
