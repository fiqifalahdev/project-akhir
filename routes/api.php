<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FeedController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']); // nanti bikin api nya

    // ================== Profile ===================
    Route::get('/profiles', [ProfileController::class, 'index']);
    Route::get('/profiles/{profile}', [ProfileController::class, 'show']);
    Route::put('/profiles', [ProfileController::class, 'update']);
    Route::delete('/profiles', [ProfileController::class, 'destroy']);


    // ================== Location ==================
    Route::post('/store/location', [LocationController::class, 'storeLocation']);
    Route::get('/locations', [LocationController::class, 'getUserLocation']);

    // ==================== Feed ====================
    Route::post('/store/feeds', [FeedController::class, 'store']);
    Route::put('/update/feeds/{feed}', [FeedController::class, 'update']);

    // ==================== Appointment ====================
    Route::post('/store/appointment-request', [AppointmentController::class, 'store']);
});
