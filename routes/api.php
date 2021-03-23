<?php

use App\Http\Controllers\SearchResultController;
use App\Http\Controllers\SearchSettingsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/search_result', [SearchResultController::class, 'store']);
    Route::post('/search_settings', [SearchSettingsController::class, 'store']);
});
