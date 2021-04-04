<?php

use App\Http\Controllers\CompanySettingsController;
use App\Http\Controllers\SearchSettingsController;
use App\Http\Controllers\PythonController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/company', [CompanySettingsController::class, 'get'])->middleware(['auth'])->name('company');
Route::post('/company', [CompanySettingsController::class, 'set'])->middleware(['auth'])->name('company');

Route::get('/', [SearchSettingsController::class, 'all'])->middleware(['auth'])->name('dashboard');
Route::get('/task/{id?}', [SearchSettingsController::class, 'get'])->middleware(['auth'])->name('task');
Route::post('/task/store', [SearchSettingsController::class, 'store'])->middleware(['auth']);

require __DIR__.'/auth.php';
