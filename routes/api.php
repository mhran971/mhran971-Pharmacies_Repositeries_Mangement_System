<?php

use App\Http\Controllers\Pharmacy\Auth\ForgotPasswordController;
use App\Http\Controllers\Pharmacy\Auth\PharmacyAuthController;
use App\Http\Controllers\Pharmacy\Authorization\PharmacyAuthorizationController;
use App\Http\Controllers\Pharmacy\Profile\ProfileController;
use App\Http\Controllers\Repository\Auth\RepositoryAuthController;
use App\Http\Controllers\Repository\Authorization\RepoAuthorizationController;
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
    Route::post('/assign-permissions/{user_id}', [RepoAuthorizationController::class, 'assign_permissions_user']);

});

Route::middleware(['auth:api'])->prefix('Repository')
    ->controller(PharmacyAuthorizationController::class)->group(function () {
        Route::get('/get-permissions/{lang}', 'get_all_permissions');
        Route::get('/all-users', 'get_all_users');
        Route::post('/assign-permissions/{user_id}', 'assign_permissions_user');

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

Route::prefix('passwordAndEmail')
    ->controller(ForgotPasswordController::class)
    ->group(function () {
        Route::post('forgotPassword', 'forgotPassword');
        Route::post('verifyCode', 'verifyCode');
        Route::post('resetPassword', 'resetPassword');
    });

Route::middleware('auth:api')->prefix('Pharmacy')->group(function () {
    Route::post('/logout', [RepositoryAuthController::class, 'logout']);
    Route::get('/my-profile', [ProfileController::class, 'get_my_profile']);
    Route::post('/update-profile', [ProfileController::class, 'edit_my_profile']);
    Route::post('/delete-profile', [ProfileController::class, 'delete_my_profile']);
});

Route::middleware(['auth:api'])->prefix('Pharmacy')
    ->controller(PharmacyAuthorizationController::class)->group(function () {
        Route::get('/get-permissions/{lang}', 'get_all_permissions');
        Route::get('/all-users', 'get_all_users');
        Route::post('/assign-permissions/{user_id}', 'assign_permissions_user');
    });


