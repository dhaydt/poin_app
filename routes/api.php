<?php

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

Route::get('/banner', [HomeController::class, 'banner']);
Route::get('/banner/{id}', [HomeController::class, 'banner_details']);

Route::get('/outlet', [HomeController::class, 'outlet']);
Route::get('/outlet/{id}', [HomeController::class, 'outlet_details']);

Route::get('/catalog', [HomeController::class, 'catalog']);
Route::get('/catalog/{id}', [HomeController::class, 'catalog_details']);

Route::get('/about_us', [HomeController::class, 'about_us']);
Route::get('/contact', [HomeController::class, 'contact']);
Route::get('/term', [HomeController::class, 'term']);

Route::middleware(['auth:sanctum'])->group(function(){
    Route::get('profile', [UserController::class, 'profile']);
    Route::get('level', [UserController::class, 'level']);
});

