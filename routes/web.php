<?php

use App\Http\Controllers\CompanySettingsController;
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
Route::get('/', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');
Route::get('/company', [CompanySettingsController::class, 'get'])->middleware(['auth'])->name('company');
Route::post('/company', [CompanySettingsController::class, 'set'])->middleware(['auth'])->name('company');

require __DIR__.'/auth.php';
