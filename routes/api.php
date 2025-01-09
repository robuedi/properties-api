<?php

use App\Http\Controllers\Api\v1\PropertyController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->name('api.v1.')->group(function () {
    Route::apiResource('properties', PropertyController::class);
})->name('v1');
