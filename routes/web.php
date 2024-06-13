<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\FishMarketController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::middleware('auth.admin')->group(function () {

    Route::get('/fish-price', function () {
        return Inertia::render('FishPrice');
    })->name('fish-price');

    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');


    Route::prefix('fish-market')->group(function () {
        Route::get('/', [FishMarketController::class, 'index'])->name('fish-market');
        Route::get('/create', [FishMarketController::class, 'create'])->name('add-fish-market');
        Route::post('/store', [FishMarketController::class, 'store'])->name('store-fish-market');
        Route::get('/edit/{id}', [FishMarketController::class, 'edit'])->name('edit-fish-market');
        Route::patch('/update/{id}', [FishMarketController::class, 'update'])->name('update-fish-market');
        Route::delete('/delete/{id}', [FishMarketController::class, 'destroy'])->name('delete-fish-market');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
