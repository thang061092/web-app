<?php

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


Route::get('/show-login', [UserController::class, 'show_login'])->name('showLogin');
Route::get('/show-register', [UserController::class, 'show_register'])->name('showRegister');
Route::post('/register', [UserController::class, 'register'])->name('register');
Route::post('/appLogin', [UserController::class, 'appLogin'])->name('appLogin');


Route::middleware('login')->group(function () {
    Route::get('/', [UserController::class, 'dashboard'])->name('dashboard');
    Route::get('/show-profile/{id}', [UserController::class, 'show_profile'])->name('showProfile');
    Route::post('/update-profile/{id}', [UserController::class, 'update_profile'])->name('updateProfile');
    Route::get('/appLogout', [UserController::class, 'logout'])->name('logout');
});

