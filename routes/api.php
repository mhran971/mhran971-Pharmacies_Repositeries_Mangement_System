<?php

use App\Http\Controllers\Operation\PharmacyStockController;
use App\Http\Controllers\Operation\SalesMovementController;
use App\Http\Controllers\Pharmacy\Auth\ForgotPasswordController;
use App\Http\Controllers\Pharmacy\Auth\PharmacyAuthController;
use App\Http\Controllers\Pharmacy\Authorization\PharmacyAuthorizationController;
use App\Http\Controllers\Pharmacy\Profile\ProfileController;
use App\Http\Controllers\Repository\Auth\RepositoryAuthController;
use App\Http\Controllers\Repository\Authorization\RepoAuthorizationController;
use App\Http\Controllers\Repository\Profile\RepoProfileController;
use App\Models\Medicine;
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
    Route::get('/my-profile', [RepoProfileController::class, 'get_my_profile']);
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
        Route::post('/forgotPassword', 'forgotPassword');
        Route::post('/verifyCode', 'verifyCode');
        Route::post('/resetPassword', 'resetPassword');
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
        Route::get('/My-Pharmacists', 'My_Pharmacists');
        Route::post('/delete-MyPharmacist/{id}', 'delete_MyPharmacists');
        Route::get('/get-permissions/Pharmacist/{id}', 'My_Pharmacist_Permissions');
        Route::get('/get-MyPermissions', 'get_MyPermissions');
        Route::post('/assignOrUpdate-Permissions/{user_id}', 'assignOrUpdatePermissions');
    });

Route::middleware('auth:api')->prefix('Pharmacy')->group(function () {
    Route::get('/pharmacy-stocks', [PharmacyStockController::class, 'pharmacy_stock']);
    Route::get('/pharmacy-stocks/expiring', [PharmacyStockController::class, 'expiringSoon']);
    Route::get('/pharmacy-stocks/lowStock', [PharmacyStockController::class, 'lowStock']);
    Route::post('/sell/bulkStore', [SalesMovementController::class, 'bulkStore']);
    Route::post('/pharmacy-stocks/add-medicines', [PharmacyStockController::class, 'Add_To_stock']);
    Route::post('/pharmacy-stocks/returned_medicine', [PharmacyStockController::class, 'Returned_Medicine']);

});


/*                =============================
                  ||        General API         ||
                  =============================                              */


Route::get('/get', function () {
    $allMedicines = collect();

    Medicine::with(['laboratory', 'pharmaceuticalForm'])
        ->chunk(6700, function ($medicines) use (&$allMedicines) {
            $updatedChunk = $medicines->map(function ($medicine) {
                return [
                    'id' => $medicine->id,
                    'trade_name' => $medicine->trade_name,
                    'laboratory_ar' => $medicine->laboratory?->name_ar ?? 'Unknown',
                    'laboratory_en' => $medicine->laboratory?->name_en ?? 'Unknown',
                    'composition' => $medicine->composition,
                    'titer' => $medicine->titer,
                    'packaging' => $medicine->packaging,
                    'pharmaceutical_form_ar' => $medicine->pharmaceuticalForm?->name_ar ?? 'Unknown',
                    'pharmaceutical_form_en' => $medicine->pharmaceuticalForm?->name_en ?? 'Unknown',
                    'created_at' => $medicine->created_at,
                    'updated_at' => $medicine->updated_at,
                ];
            });

            $allMedicines = $allMedicines->merge($updatedChunk);
        });

    return response()->json($allMedicines->values());
});

Route::get('/getforms', function () {
    return $Pharmaceutical_Forms = \App\Models\Pharmaceutical_Form::query()
        ->select('id', 'name_ar', 'name_en', 'image_path')
        ->get();
});

//Route::get('/getforms_en', function () {
//    return $Pharmaceutical_Forms = \App\Models\Pharmaceutical_Form::query()
//        ->select('id', 'name_en')
//        ->get();
//});

Route::get('/getcompanies', function () {
    return $laboratories = \App\Models\laboratory::query()
        ->select('id', 'name_ar', 'name_en', 'image_path')
        ->get();

});

//Route::get('/getcompanies_en', function () {
//    return $laboratories = \App\Models\laboratory::query()
//        ->select('id', 'name_en', 'image_path')
//        ->get();
//});

Route::get('/getusers', function () {
    return $Users = \App\Models\User::query()->get();
});

Route::get('/get/medbylaboratory_id/{laboratory_id}', function (string $laboratory_id) {
    return $allMedicines = \App\Models\Medicine::query()->with('pharmaceuticalForm')
        ->where('laboratory_id', $laboratory_id)->get();
});

Route::get('/get/medbyForm_id/{Pharmaceutical_Form_id}', function (string $Pharmaceutical_Form_id) {
    return $allMedicines = \App\Models\Medicine::query()->with('laboratory')
        ->where('Pharmaceutical_Form_id', $Pharmaceutical_Form_id)->get();
});
