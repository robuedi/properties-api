<?php

use App\Http\Controllers\Api\v1\CityController;
use App\Http\Controllers\Api\v1\CountryController;
use App\Http\Controllers\Api\v1\PropertyAddressController;
use App\Http\Controllers\Api\v1\PropertyController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->name('api.v1.')->group(function () {
    Route::apiResource('properties', PropertyController::class);

    Route::resource('countries', CountryController::class)->only([
        'index', 'show',
    ]);

    Route::resource('cities', CityController::class)->only([
        'index', 'show',
    ]);

    Route::prefix('properties/{property}/address')->group(function () {
        Route::get('/', [PropertyAddressController::class, 'show'])->name('properties.address.show');
        Route::post('/', [PropertyAddressController::class, 'store'])->name('properties.address.store');
        Route::put('/', [PropertyAddressController::class, 'update'])->name('properties.address.update');
        Route::delete('/', [PropertyAddressController::class, 'destroy'])->name('properties.address.destroy');
    });
});
