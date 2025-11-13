<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CosmeticController;
use App\Services\CosmeticService;
use App\Repositories\CosmeticRepository;
use App\Utils\FortniteAPIUtil;


// Route::get('/', function () {

//     $repository = new CosmeticRepository;
//     $util = new FortniteAPIUtil;
//     $service = new CosmeticService($util, $repository);
//     $controller = new CosmeticController($service);
//     $controller->syncAllCosmetics();
// });

Auth::routes();


Route::get('/{vue_capture?}', function () {
    return view('app');
})->where('vue_capture', '[\/\w\.-]*');