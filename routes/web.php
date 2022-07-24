<?php

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
//Route::match(['post', 'get'], '/', [\App\Http\Controllers\Admin\AbsenController::class, 'index']);
Route::match(['post', 'get'], '/', [\App\Http\Controllers\AuthController::class, 'login']);
Route::get('/logout', [\App\Http\Controllers\AuthController::class, 'logout']);
Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index']);

Route::group(['prefix' => 'admin'], function () {
    Route::get( '/', [\App\Http\Controllers\Admin\AdminController::class, 'index']);
    Route::get( '/tambah', [\App\Http\Controllers\Admin\AdminController::class, 'add_page']);
    Route::post( '/create', [\App\Http\Controllers\Admin\AdminController::class, 'create']);
    Route::get( '/edit/{id}', [\App\Http\Controllers\Admin\AdminController::class, 'edit_page']);
    Route::post( '/patch', [\App\Http\Controllers\Admin\AdminController::class, 'patch']);
    Route::post( '/delete', [\App\Http\Controllers\Admin\AdminController::class, 'destroy']);
});

Route::group(['prefix' => 'guru'], function () {
    Route::get( '/', [\App\Http\Controllers\Admin\MemberController::class, 'index']);
    Route::get( '/tambah', [\App\Http\Controllers\Admin\MemberController::class, 'add_page']);
    Route::post( '/create', [\App\Http\Controllers\Admin\MemberController::class, 'create']);
    Route::get( '/edit/{id}', [\App\Http\Controllers\Admin\MemberController::class, 'edit_page']);
    Route::post( '/patch', [\App\Http\Controllers\Admin\MemberController::class, 'patch']);
    Route::post( '/delete', [\App\Http\Controllers\Admin\MemberController::class, 'destroy']);
});

Route::group(['prefix' => 'absen'], function () {
    Route::get( '/', [\App\Http\Controllers\Admin\AbsenController::class, 'index']);
    Route::get( '/tambah', [\App\Http\Controllers\Admin\AbsenController::class, 'add_page']);
    Route::post( '/create', [\App\Http\Controllers\Admin\AbsenController::class, 'create']);
    Route::get( '/{id}/detail', [\App\Http\Controllers\Admin\AbsenController::class, 'edit_page']);
    Route::post( '/patch', [\App\Http\Controllers\Admin\AbsenController::class, 'patch']);
    Route::post( '/delete', [\App\Http\Controllers\Admin\AbsenController::class, 'destroy']);
});

Route::group(['prefix' => 'lokasi'], function () {
    Route::match(['post', 'get'], '/', [\App\Http\Controllers\Admin\LokasiController::class, 'index']);
});

Route::group(['prefix' => 'laporan-absen'], function () {
    Route::get( '/', [\App\Http\Controllers\Admin\LaporanController::class, 'laporan_absen']);
    Route::get( '/data', [\App\Http\Controllers\Admin\LaporanController::class, 'laporan_absen_data']);
    Route::get( '/cetak', [\App\Http\Controllers\Admin\LaporanController::class, 'laporan_absen_cetak']);
});

