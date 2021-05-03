<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
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
    return redirect('login');
});

Route::match(['get', 'post'], '/login', [AuthController::class, 'login'])->name('login');
Route::match(['get', 'post'], '/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', [AuthController::class, 'logout']);

Route::get('/forget-password', [AuthController::class, 'getEmail'])->name('forget-password');
Route::post('forget-password', [AuthController::class, 'postEmail'])->name('forget-password');

Route::match(['get', 'post'],'reset-password/{token}', [AuthController::class, 'getPassword'])->name('reset-password');
Route::match(['get', 'post'],'reset-password', [AuthController::class,'updatePassword'])->name('reset-password');
//activate email

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
});

