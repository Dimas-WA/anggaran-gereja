<?php

use App\Http\Controllers\LoginController;
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


});
