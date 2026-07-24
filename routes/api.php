<?php

use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\RoomController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RoomTypeController;

Route::apiResource('room-types', RoomTypeController::class);
Route::apiResource('rooms', RoomController::class);
Route::apiResource('bookings', BookingController::class);
