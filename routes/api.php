<?php

use App\Http\Controllers\Api\BookingTransactionController;
use App\Http\Controllers\Api\CityController;
use App\Http\Controllers\Api\OfficeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('api_key')->group(function(){
    Route::get('/city/{city:slug}', [CityController::class, 'show']);
    Route::apiResource('/cities', CityController::class);

    Route::get('/officespace/{officeSpace:slug}', [OfficeController::class, 'show']);
    Route::apiResource('/officespaces', OfficeController::class);

    Route::post('/booking-transaction', [BookingTransactionController::class, 'store']);
    Route::post('/check-booking-transaction', [BookingTransactionController::class, 'bookingdetails']);
});

