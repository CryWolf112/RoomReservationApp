<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;

Route::middleware(['auth', 'prevent-back-history'])->group(function () {
    Route::middleware(['admin'])->group(function () {
    });

    Route::group([
        'middleware' => 'admin'
    ], function() {
        
    });

    Route::post('/news/update', [HomeController::class, 'newsUpdate']);
    Route::get('/home/profile', [UserController::class, 'profile']);
    Route::get('/home', [UserController::class, 'home']);
    Route::get('/logout', [UserController::class, 'logout']);
    Route::get('/changeEmail', [UserController::class, 'changeEmail']);
});

Route::middleware(['prevent-back-history'])->group(function () {
    Route::get('/verifyEmail', [UserController::class, 'verifyEmail']);
    Route::get('/verifyEmailChange', [UserController::class, 'verifyEmailChange']);
    Route::get('/forgotPassword', [UserController::class, 'forgotPassword']);
    Route::get('/resetPassword', [UserController::class, 'resetPassword']);
    Route::post('/validatePasswordReset', [UserController::class, 'validatePasswordReset']);
});

Route::middleware(['guest'])->group(function () {
    Route::get('/', [HomeController::class, 'index']);
    Route::get('/login', [UserController::class, 'login']);
    Route::get('/register', [UserController::class, 'register']);
});

Route::get('/news', [HomeController::class, 'news']);
Route::get('/contact', [HomeController::class, 'contact']);
Route::get('/about', [HomeController::class, 'about']);

//post
Route::post('/validate', [UserController::class, 'validateRegistration']);
Route::post('/authenticate', [UserController::class, 'authenticate']);
Route::post('/validateNewPassword', [UserController::class, 'validateNewPassword']);
Route::post('/home/profile/profileHandler', [UserController::class, 'profileHandler']);
Route::post('/validateMailChange', [UserController::class, 'validateMailChange']);
Route::post('/sendQuery', [HomeController::class, 'sendQuery']);