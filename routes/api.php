<?php

use App\Http\Controllers\Pharmacy\Auth\PharmacyAuthController;
use App\Http\Controllers\Repository\Auth\RepositoryAuthController;
use Illuminate\Support\Facades\Route;

/*                =============================
                  ||        Repository       ||
                  =============================                              */

// Repository Auth operation :

Route::prefix('Repository')
    ->controller(RepositoryAuthController::class)
    ->group(function () {
        Route::post('/owner-register', 'Repo_Owner_registering');
        Route::post('/employee-register', 'Employee_registering');
        Route::post('/login', 'login');
    });

Route::prefix('Repository')->middleware('auth:api')->group(function () {
    Route::post('/logout', [RepositoryAuthController::class, 'logout']);
});


/*                =============================
                  ||        Pharmacy         ||
                  =============================                              */

Route::prefix('Pharmacy')
    ->controller(PharmacyAuthController::class)
    ->group(function () {
        Route::post('owner-register', 'Pharmacy_owner_registering');
        Route::post('Pharmacist-register', 'Pharmacist_registration');
        Route::post('/login', 'login');

    });
Route::middleware('auth:api')->prefix('Pharmacy')->group(function () {

});


