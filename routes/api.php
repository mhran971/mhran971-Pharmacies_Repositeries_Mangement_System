<?php

use App\Http\Controllers\Pharmacy\Auth\PharmacyAuthController;
use App\Http\Controllers\Pharmacy\Profile\ProfileController;
use App\Http\Controllers\Repository\Auth\RepositoryAuthController;
use App\Http\Controllers\Repository\Profile\RepoProfileController;
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
    Route::post('/my-profile', [RepoProfileController::class, 'get_my_profile']);
    Route::post('/update-profile', [RepoProfileController::class, 'edit_my_profile']);
    Route::post('/delete-profile', [RepoProfileController::class, 'delete_my_profile']);
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
    Route::post('/logout', [RepositoryAuthController::class, 'logout']);
    Route::get('/my-profile', [ProfileController::class, 'get_my_profile']);
    Route::post('/my-profile', [ProfileController::class, 'get_my_profile']);
    Route::post('/update-profile', [ProfileController::class, 'edit_my_profile']);
    Route::post('/delete-profile', [ProfileController::class, 'delete_my_profile']);
});


