<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\MasterAnggaranController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SeksiController;
use App\Http\Controllers\SettingController;
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

    Route::resource('master-anggaran', MasterAnggaranController::class);

    Route::resource('settings', SettingController::class);

});

Route::get('tes-wa', [SettingController::class, 'tes_wa'])->name('tes.wa');
