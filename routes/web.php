<?php

use App\Http\Controllers\OtorisasiController;
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
    return view('welcome');
});

Route::get('admin/login', function () {
    return view('admin/login', ['title' => "Login | " . config('variable.webname')]);
})->name('admin.login');
Route::post('admin/auth', [OtorisasiController::class, 'auth'])->name('admin.auth');
Route::get('admin/logout', [OtorisasiController::class, 'logout'])->name('admin.logout');

Route::group(['prefix' => 'admin',  'middleware' => 'adminauth'], function () {
    Route::get('/', function () {
        return view('admin/dashboard', ['title' => "Dashboard"]);
    })->name('admin.dashboard');
    //Admin
    Route::get('otorisasi', [OtorisasiController::class, 'index'])->name('admin.otorisasi.index');
    Route::post('otorisasi/create', [OtorisasiController::class, 'create'])->name('admin.otorisasi.create');
    Route::put('otorisasi/update', [OtorisasiController::class, 'update'])->name('admin.otorisasi.update');
    Route::delete('otorisasi/delete', [OtorisasiController::class, 'delete'])->name('admin.otorisasi.delete');
    Route::post('otorisasi/data', [OtorisasiController::class, 'data'])->name('admin.otorisasi.data');
});
