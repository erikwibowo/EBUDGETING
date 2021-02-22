<?php

use App\Http\Controllers\InputAnggaranController;
use App\Http\Controllers\InputRincianRkaController;
use App\Http\Controllers\InputRkaController;
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
    return view('admin/login', ['title' => "Login | " . config('variable.webname')]);
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

    //INPUT ANGGARAN
    Route::get('input-anggaran/penyusunan', [InputAnggaranController::class, 'penyusunan'])->name('admin.input-anggaran.penyusunan');
    Route::get('input-anggaran/parsial1', [InputAnggaranController::class, 'parsial1'])->name('admin.input-anggaran.parsial1');

    //Input RKA
    //Parsial 1
    Route::get('input-rka/parsial1', [InputRkaController::class, 'parsial1'])->name('admin.input-rka.parsial1');
    Route::post('input-rka/parsial1/create', [InputRkaController::class, 'create_parsial1'])->name('admin.input-rka.create-parsial1');
    Route::delete('input-rka/parsial1/delete', [InputRkaController::class, 'delete_parsial1'])->name('admin.input-rka.delete-parsial1');

    //Input Rincian RKA
    //Parsial 1
    Route::get('input-rincian-rka/parsial1', [InputRincianRkaController::class, 'parsial1'])->name('admin.input-rincian-rka.parsial1');
    Route::post('input-rincian-rka/parsial1/create', [InputRincianRkaController::class, 'create_parsial1'])->name('admin.input-rincian-rka.create-parsial1');
    Route::put('input-rincian-rka/parsial1/update', [InputRincianRkaController::class, 'update_parsial1'])->name('admin.input-rincian-rka.update-parsial1');
    Route::delete('input-rincian-rka/parsial1/delete', [InputRincianRkaController::class, 'delete_parsial1'])->name('admin.input-rincian-rka.delete-parsial1');
    Route::post('input-rincian-rka/data-rinci-parsial1', [InputRincianRkaController::class, 'data_rinci_parsial1'])->name('admin.input-rincian-rka.data-rinci-parsial1');
    
    Route::post('input-rincian-rka/parsial1/create-header', [InputRincianRkaController::class, 'create_header_parsial1'])->name('admin.input-rincian-rka.create-header-parsial1');
    Route::put('input-rincian-rka/parsial1/update-header', [InputRincianRkaController::class, 'update_header_parsial1'])->name('admin.input-rincian-rka.update-header-parsial1');
});
