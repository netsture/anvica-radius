<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AdvertisementApiController;
use App\Http\Controllers\RouterstatusController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('getAds/video', [AdvertisementApiController::class, 'getVideo']);
Route::get('getAds/image', [AdvertisementApiController::class, 'getImage']);
Route::get('getAds', [AdvertisementApiController::class, 'getAdvertise']);

// Route::get('getAds', [AdvertisementApiController::class, 'getAdvertise']);
Route::get('viewAds/{id}', [AdvertisementApiController::class, 'viewAdvertise']);
Route::get('clickAds/{id}', [AdvertisementApiController::class, 'clickAdvertise']);

Route::post('/router-status', [RouterstatusController::class, 'store']);


// fallback for everything else under /api
Route::fallback(function () {
    return response()->json([
        'status' => false,
        'message' => 'Unauthorized'
    ], 401);
});