<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CosmeticController;
use App\Http\Controllers\UserController;

Route::get('/', function (Request $request) {
    return "API Fortnite";
});

Route::post('/login', [UserController::class, 'login']);

Route::prefix('/user')->controller(UserController::class)->group(function () {
    Route::post('/', 'create');
    Route::get('/my-vbucks', 'userTotalVBucks')->middleware('auth');
    Route::get('/ballance', 'userVBuckBallance')->middleware('auth');
});

Route::prefix('/cosmetics')->controller(CosmeticController::class)->group(function () {
    Route::get('/', 'list');
    Route::get('/sync', 'syncAllCosmetics');
    Route::get('/my', 'listComesticsByUserID')->middleware('auth');
    Route::post('/add', 'addCosmeticToUser')->middleware('auth');
});