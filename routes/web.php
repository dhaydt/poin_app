<?php

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
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

Route::get('/storage-link', function () {
    Artisan::call('storage:link');
    dd('Storage linked!');
});
Route::get('/config-cache', function () {
    Artisan::call('config:cache');
    dd('config cleared!');
});

Route::get('/migrate', function () {
    Artisan::call('migrate', [
        '--force' => true,
    ]);
    dd('migrated!');
})->name('migrate');
Route::get('/seed', function () {
    Artisan::call('db:seed', [
        '--force' => true,
    ]);
    dd('seeded!');
});

Route::get('export', [Controller::class, 'export'])->name('export');
Route::get('export-poin', [Controller::class, 'export_poin'])->name('export.poin');

Route::post('broadcast', [Controller::class, 'broadcast'])->name('broadcast');

Route::get('reset/{is_admin}', [Controller::class, 'reset'])->name('reset');
Route::get('export-customer', [Controller::class, 'export_customer'])->name('export.customer');

Route::post('change-password', [Controller::class, 'changePassword'])->name('password');

Route::get('/', function () {
    return redirect()->route('filament.auth.login');
})->name('login');
