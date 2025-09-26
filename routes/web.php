<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\UserController;
use \App\Http\Controllers\CategoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::middleware(['auth', 'role'])->prefix('admin')->group(function () {
    Route::get('/', function () {
        return view('admin.layouts.main_layout');
    })->name('admin');
    Route::resource('users', UserController::class);
    Route::resource('category', CategoryController::class);
    Route::resource('products', \App\Http\Controllers\ProductController::class);
});

// Auth

Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'postRegister'])->name('postRegister');

Route::get('/a-login', [AuthController::class, 'login'])->name('a-login');
Route::post('/a-login', [AuthController::class, 'postLoginAdmin'])->name('postLoginAdmin');

Route::get('/a-logout', [AuthController::class, 'logoutAdmin'])->name('logoutAdmin');
