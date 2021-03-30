<?php

use App\Http\Controllers\PythonController;
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

Route::get('/check_auth', [PythonController::class, 'checkAuth']);
Route::get('/get_task', [PythonController::class, 'getTask']);
Route::post('/send_order', [PythonController::class, 'order']);
Route::post('/chrome', [PythonController::class, 'chrome']);

Route::middleware('auth:api')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    //????Route::post('/search_result', [SearchResultController::class, 'store']);
    Route::post('/search_settings', [SearchSettingsController::class, 'store']);
});
