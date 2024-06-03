<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\MasterAnggaranController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoutingApprovalController;
use App\Http\Controllers\SeksiController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\TahunAnggaranController;
use App\Http\Controllers\TrxAnggaranDetailController;
use App\Http\Controllers\TrxAnggaranHeaderController;
use App\Http\Controllers\TrxRealisasiAnggaranHeaderController;
use App\Http\Controllers\UserController;
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
Route::get('login', [LoginController::class, 'index'])->name('login');
Route::post('login', [LoginController::class, 'login'])->name('login.post');
Route::get('forgot-password', [LoginController::class, 'forgot_pass'])->name('forgot.pass');
Route::post('forgot-password', [LoginController::class, 'forgot_pass_store'])->name('forgot_pass.post');
Route::get('/reload-captcha', [LoginController::class, 'reloadCaptcha']);

// Route::get('/', function () {
//     return view('welcome');
// });


Route::middleware('auth')->group(function () {

    Route::get('/', function () {
        return view('dashboard');
        // return redirect(route('calendar.dashboard'));
    });
    Route::get('dashboard', function () {
        return view('dashboard');
        // return redirect(route('calendar.dashboard'));
    })->name('dashboard');

    Route::resource('users', UserController::class);

    Route::get('user-profile', [UserController::class, 'user_profile'])->name('user.profile');


    Route::get('profile', [UserController::class, 'profile'])->name('profile.form');
    Route::get('logout', [LoginController::class, 'logout'])->name('logout');


    Route::resource('profiles', ProfileController::class);


    Route::get('profiles-upload', [ProfileController::class, 'upload'])->name('profiles-upload.create');
    Route::post('profiles-upload', [ProfileController::class, 'store_upload'])->name('profiles-upload.store');

    Route::resource('seksi', SeksiController::class);

    Route::resource('tahun-anggaran', TahunAnggaranController::class);

    Route::resource('master-anggaran', MasterAnggaranController::class);
    Route::get('delete-master-anggaran/{id}', [MasterAnggaranController::class, 'delete'])->name('master-anggaran.delete');

    Route::resource('trx-anggaran', TrxAnggaranHeaderController::class);
    Route::get('trx-anggaran-request', [TrxAnggaranHeaderController::class, 'request_app'])->name('trx-anggaran.req');

    Route::get('send-trx-anggaran/{id}', [TrxAnggaranHeaderController::class, 'send'])->name('trx-anggaran.send');
    Route::post('app_rej-trx-anggaran', [TrxAnggaranHeaderController::class, 'approve_reject'])->name('trx-anggaran.app_rej');
    Route::get('realisasi-trx-anggaran/{id}', [TrxRealisasiAnggaranHeaderController::class, 'realisasi'])->name('trx-anggaran.realisasi');
    Route::post('add_realisasi-trx-anggaran', [TrxRealisasiAnggaranHeaderController::class, 'add_realisasi'])->name('trx-anggaran.add_realisasi');
    Route::get('send-realisasi-trx-anggaran/{id}', [TrxRealisasiAnggaranHeaderController::class, 'send_realisasi'])->name('trx-anggaran.send_realisasi');
    Route::get('trx-anggaran-realisasi-request', [TrxRealisasiAnggaranHeaderController::class, 'request_app'])->name('trx-anggaran-realisasi.req');
    Route::post('app_rej-trx-anggaran-realisasi', [TrxRealisasiAnggaranHeaderController::class, 'approve_reject'])->name('trx-anggaran-realisasi.app_rej');
    Route::post('add-trx-anggaran-detail', [TrxAnggaranHeaderController::class, 'add_trx_anggaran_detail'])->name('trx-anggaran.add');
    Route::get('delete-trx-anggaran-detail/{id}', [TrxAnggaranDetailController::class, 'delete'])->name('trx-anggaran-detail.delete');

    Route::resource('settings', SettingController::class);
    Route::resource('routing-approvals', RoutingApprovalController::class);

});

Route::get('tes-wa', [SettingController::class, 'tes_wa'])->name('tes.wa');
