<?php

use App\Http\Controllers\CompanySettingsController;
use App\Http\Controllers\OrderController;
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
Route::get('/company', [CompanySettingsController::class, 'get'])->middleware(['auth'])->name('company');
Route::post('/company', [CompanySettingsController::class, 'set'])->middleware(['auth'])->name('company');

Route::get('/', [SearchSettingsController::class, 'all'])->middleware(['auth'])->name('dashboard');
Route::get('/task/{id?}', [SearchSettingsController::class, 'get'])->middleware(['auth'])->name('task');
Route::post('/task/store', [SearchSettingsController::class, 'store'])->middleware(['auth']);
Route::post('/task/start', [SearchSettingsController::class, 'start'])->middleware(['auth'])->name('start');
Route::post('/task/test', [SearchSettingsController::class, 'test'])->middleware(['auth'])->name('test');
Route::post('/task/stop', [SearchSettingsController::class, 'stop'])->middleware(['auth'])->name('stop');

// TODO: Delete after release
// Route::get('/smtp', [SmtpController::class, 'get'])->middleware(['auth'])->name('smtp');
// Route::post('/smtp', [SmtpController::class, 'store'])->middleware(['auth'])->name('smtp');
// Route::get('/test_email', [SmtpController::class, 'testEmail']);

Route::get('/orders/{taskId}', [OrderController::class, 'get'])->middleware(['auth'])->name('orders');
Route::get('/clean', [OrderController::class, 'clean'])->middleware(['auth'])->name('clean');

require __DIR__.'/auth.php';
