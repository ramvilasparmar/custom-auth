<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::group(['middleware' => ['guest'] ], function(){
    // Register
    // Route::get('register', [AuthController::class, "register"])->name('register');
    Route::match(['get', 'post'], 'register', [AuthController::class, 'register'])->name('register');

    // Login
    Route::match(['get', 'post'], 'login', [AuthController::class, "login"])->name('login');
}); // middleware guest end

Route::group(['middleware' => ['auth']], function(){
    // Dashboard
    Route::get('dashboard', [AuthController::class, "dashboard"])->name('dashboard');

    // Profile
    Route::match(['get', 'post'], 'profile', [AuthController::class, "profile"])->name('profile');

    // Logout
    Route::get('logout', [AuthController::class, "logout"])->name('logout');
});

