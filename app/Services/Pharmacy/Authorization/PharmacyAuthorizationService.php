<?php

namespace App\Services\Pharmacy\Authorization;

use App\Models\Permission;

class PharmacyAuthorizationService
{
    public function get_permissions($lang): \Illuminate\Support\Collection
    {
        if ($lang == 'ar') {
            $data = $ar_data = Permission::all()->pluck('name_ar');
        }
        if ($lang == 'en')
            $data = $en_data = Permission::all()->pluck('name_en');
        return $data;
    }
}
