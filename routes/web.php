<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\FrontController;
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

// Route Halaman Bermain
Route::get('/', [FrontController::class, 'index'])->name('home');
Route::get('/kategori/{id}', [FrontController::class, 'show'])->name('kategori.show');

// Endpoint ringan untuk Alpine.js via Fetch API
Route::get('/api/kategori/{id}/huruf/{huruf}', [FrontController::class, 'getWordsByLetter']);
Route::get('/api/kata/{id}/toggle', [FrontController::class, 'toggleStatus']);

// Route Halaman Admin
Route::prefix('admin')->name('admin')->group(function(){
    Route::get('/', [AdminController::class, 'index'])->name('index');

    // CRUD kategori
    Route::post('/kategori', [AdminController::class, 'storeKategori'])->name('kategori.store');
    Route::delete('/kategori/{id}', [AdminController::class, 'destroyKategori'])->name('kategori.destroy');

    // Import Kata dan Reset
    Route::post('/kata/import', [AdminController::class, 'importKata'])->name('kata.import');
    Route::post('kategori/{id}/reset', [AdminController::class, 'resetKata'])->name('kata.reset');
});
