<?php

use App\Http\Controllers\Api\Admin\PoinController;
use App\Http\Controllers\Api\Admin\UserController as AdminUserController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\UserController;
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
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/forgot-password', [AuthController::class, 'forgot']);

Route::get('/reward', [HomeController::class, 'reward']);

Route::get('/banner', [HomeController::class, 'banner']);
Route::get('/banner/{id}', [HomeController::class, 'banner_details']);

Route::get('/outlet', [HomeController::class, 'outlet']);
Route::get('/outlet/{id}', [HomeController::class, 'outlet_details']);

Route::get('/catalog', [HomeController::class, 'catalog']);
Route::get('/catalog/{id}', [HomeController::class, 'catalog_details']);

Route::get('/about_us', [HomeController::class, 'about_us']);
Route::get('/contact', [HomeController::class, 'contact']);
Route::get('/term', [HomeController::class, 'term']);

Route::get('/province', [HomeController::class, 'province']);
Route::get('/city/{id}', [HomeController::class, 'city']);
Route::get('/occupation', [HomeController::class, 'occupation']);

Route::middleware(['auth:sanctum'])->group(function(){
    Route::get('profile', [UserController::class, 'profile']);
    Route::post('update_profile', [UserController::class, 'update_profile']);
    Route::post('update_pin', [UserController::class, 'update_pin']);
    Route::get('level', [UserController::class, 'level']);
    Route::post('update_fcm', [UserController::class, 'update_fcm']);
    Route::post('stamp_history', [UserController::class, 'stamp_history']);
    Route::post('total_stamp', [UserController::class, 'total_stamp']);
    Route::post('is_notify', [UserController::class, 'is_notify']);

    Route::prefix('karyawan')->group(function(){
        Route::get('profile', [AdminUserController::class, 'profile']);
        Route::post('add_stamp', [PoinController::class, 'add_stamp']);
        Route::post('redeem_stamp', [PoinController::class, 'redeem_stamp']);
        Route::post('pin_edit', [AdminUserController::class, 'pin_edit']);
    });
});

