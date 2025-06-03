<?php

use App\Models\Permission;
use Illuminate\Support\Facades\Route;

Route::get('/get_permissions', function () {
    $data = Permission::all()->pluck('name_ar');
    dd($data);
});
