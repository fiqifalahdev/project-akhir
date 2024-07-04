<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FeedController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileApiController;
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

    // ================== User ===================
    Route::get('/get/all-users', [ProfileApiController::class, 'getAllUsers']);

    // ================== Profile ===================
    Route::get('/profiles', [ProfileApiController::class, 'index']);
    Route::get('/profiles/{profile}', [ProfileApiController::class, 'show']);
    Route::put('/profiles', [ProfileApiController::class, 'update']);
    Route::delete('/profiles', [ProfileApiController::class, 'destroy']);

    // ================== Location ==================
    Route::post('/store/location', [LocationController::class, 'storeLocation']);
    Route::get('/get/current-location', [LocationController::class, 'getCurrentLocation']);
    Route::get('/locations', [LocationController::class, 'getUserLocation']);
    Route::post('/locations/target', [LocationController::class, 'getTargetLocation']);

    // ==================== Feed ====================
    Route::get('/get/feeds/{feed}', [FeedController::class, 'show']);
    Route::post('/store/feeds', [FeedController::class, 'store']);
    Route::put('/update/feeds/{feed}', [FeedController::class, 'update']);

    // ==================== Appointment ====================
    Route::get('/get/appointment-request', [AppointmentController::class, 'appointmentRequest']);
    Route::get('/get/appointment-recipient', [AppointmentController::class, 'appointmentRecipient']);
    Route::post('/store/appointment-request', [AppointmentController::class, 'store']);
    Route::post('/update/appointment-request/{appointment}', [AppointmentController::class, 'updateAppointmentStatus']);

    // ==================== Notification ====================
    Route::post('/store/user-token', [NotificationController::class, 'storeToken']);
});
