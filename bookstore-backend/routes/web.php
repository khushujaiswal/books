<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BookController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
Route::post('/submitLogin', [AdminAuthController::class, 'submitLogin'])->name('submitLogin');
Route::get('/logout', [AdminAuthController::class, 'submitLogout'])->name('logout');
Route::get('/dashboard', [DashboardController::class, 'showDashboard'])->name('dashboard');
Route::get('/books', [BookController::class, 'showBookList'])->name('books');
Route::get('/add-book', [BookController::class, 'addBook'])->name('add-book');
Route::post('/store-book', [BookController::class, 'storeBook'])->name('store-book');
Route::get('/edit-book/{id}/edit', [BookController::class, 'editBook'])->name('edit-book');
Route::delete('/destroy-book/{id}', [BookController::class, 'destroyBook'])->name('destroy-book');
Route::put('/update-book/{id}', [BookController::class, 'updateBook'])->name('update-book');
