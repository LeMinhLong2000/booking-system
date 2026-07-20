<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RoomTypeController;

Route::apiResource('room-types', RoomTypeController::class);
