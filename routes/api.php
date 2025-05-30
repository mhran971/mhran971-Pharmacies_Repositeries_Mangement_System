<?php

use App\Http\Controllers\Repository\Auth\AuthController;
use Illuminate\Support\Facades\Route;

// Repository Auth operation :

Route::prefix('Repository')
    ->controller(AuthController::class)
    ->group(function () {
        Route::post('owner-register', 'Repo_Owner_registering');
        Route::post('employee-register', 'Employee_registering');
    });


Route::middleware('auth:api')->prefix('Repository')->group(function () {

});

