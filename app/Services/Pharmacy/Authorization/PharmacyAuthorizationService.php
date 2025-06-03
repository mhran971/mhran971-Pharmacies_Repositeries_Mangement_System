<?php

namespace App\Services\Pharmacy\Authorization;

use App\Models\Permission;

class PharmacyAuthorizationService
{
    public function get_permissions($lang): \Illuminate\Support\Collection
    {
        if ($lang == 'ar') {
            return $ar_data = Permission::all()->pluck('name_ar');
        }
        if ($lang == 'en') {
            return $en_data = Permission::all()->pluck('name_en');
        }

    }
}
