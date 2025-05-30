<?php

use App\Http\Controllers\Pharmacy\Auth\PharmacyAuthController;
use App\Http\Controllers\Repository\Auth\RepositoryAuthController;
use Illuminate\Support\Facades\Route;

// Repository Auth operation :

Route::prefix('Repository')
    ->controller(RepositoryAuthController::class)
    ->group(function () {
        Route::post('owner-register', 'Repo_Owner_registering');
        Route::post('employee-register', 'Employee_registering');
    });

Route::middleware('auth:api')->prefix('Repository')->group(function () {

});

Route::prefix('Pharmacy')
    ->controller(PharmacyAuthController::class)
    ->group(function () {
        Route::post('owner-register', 'Pharmacy_owner_registering');
        Route::post('Pharmacist-register', 'Pharmacist_registration');
    });
Route::middleware('auth:api')->prefix('Pharmacy')->group(function () {

});


