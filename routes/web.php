<?php

use App\Http\Controllers\BlacklistController;
use App\Http\Controllers\CompanySettingsController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SmtpController;
use App\Http\Controllers\SearchSettingsController;
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
// Route::get('/company', [CompanySettingsController::class, 'get'])->middleware(['auth'])->name('company');
// Route::post('/company', [CompanySettingsController::class, 'set'])->middleware(['auth'])->name('company');

// Route::get('/', [SearchSettingsController::class, 'all'])->middleware(['auth'])->name('dashboard');
// Route::get('/task/{id?}', [SearchSettingsController::class, 'get'])->middleware(['auth'])->name('task');
// Route::post('/task/store', [SearchSettingsController::class, 'store'])->middleware(['auth']);
// Route::post('/task/start', [SearchSettingsController::class, 'start'])->middleware(['auth'])->name('start');
// Route::post('/task/test', [SearchSettingsController::class, 'test'])->middleware(['auth'])->name('test');
// Route::post('/task/stop', [SearchSettingsController::class, 'stop'])->middleware(['auth'])->name('stop');

// Route::get('/orders/{taskId}', [OrderController::class, 'get'])->middleware(['auth'])->name('orders');
// Route::get('/clean', [OrderController::class, 'clean'])->middleware(['auth'])->name('clean');

// Route::get('/blacklist', [BlacklistController::class, 'get'])->middleware(['auth'])->name('blacklist');
// Route::post('/blacklist/store', [BlacklistController::class, 'store'])->middleware(['auth'])->name('blacklist.store');
// Route::post('/blacklist/delete', [BlacklistController::class, 'delete'])->middleware(['auth'])->name('blacklist.delete');
