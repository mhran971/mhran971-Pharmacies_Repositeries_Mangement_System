<?php

namespace App\Services\Pharmacy\Authorization;

use App\Http\Requests\Pharmacy\Authorization\Assign_PermissionRequest;
use App\Models\Permission;
use App\Models\Pharmacy;
use App\Models\Pharmacy_User;
use App\Models\PharmacyUserPermission;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class PharmacyAuthorizationService
{
    public function get_users(): array
    {
        $allUsers = [];

        User::Select('id', 'name')->chunk(100, function ($usersChunk) use (&$allUsers) {
            foreach ($usersChunk as $user) {
                $allUsers[] = $user;
            }
        });

        return $allUsers;
    }

    public function MyPermissions()
    {
        $user = Auth::user();

        $pharmacyUserIds = Pharmacy_User::where('user_id', $user->id)->pluck('id');
        $permissionIds = PharmacyUserPermission::whereIn('pharmacy_user_id', $pharmacyUserIds)
            ->pluck('permission_id');
        return $permissions = Permission::whereIn('id', $permissionIds)->get();

    }

    public function get_myPharmacists()
    {

        $user = Auth::user();
        $pharmacy_ids = Pharmacy::where('owner_id', $user->id)->pluck('id')->toarray();
        return $user_ids = Pharmacy_User::whereIn('pharmacy_id', $pharmacy_ids)->where('is_work',1)->with('user')->get();
//         $users = User::whereIn('id', $user_ids)->get();

    }

    public function delete_MyPharmacists($Pharmacist_id)
    {
        $owner = Auth::user();

        $pharmacy_id = Pharmacy::where('owner_id', $owner->id)->value('id');

        $pharmacyUser = Pharmacy_User::where('user_id', $Pharmacist_id)
            ->where('pharmacy_id', $pharmacy_id)
            ->first();

        if ($pharmacyUser) {
            $pharmacyUser->delete();
        } else {
            return "The Pharmacist already hasn't exist in your pharmacy!";
        }

        $user = User::find($Pharmacist_id);

        return "The Pharmacist {$user?->name} has been removed from your pharmacy successfully";
    }


    public function get_Pharmacist_permissions_perId($pharmacist_id)
    {
        $user = Auth::user();

        $pharmacyIds = Pharmacy::where('owner_id', $user->id)->pluck('id');
        $pharmacyUserIds = Pharmacy_User::whereIn('pharmacy_id', $pharmacyIds)
            ->where('user_id', $pharmacist_id)
            ->pluck('id');
        $pharmacistPermissions = PharmacyUserPermission::whereIn('pharmacy_user_id', $pharmacyUserIds)
            ->pluck('permission_id');
        return $pharmacistPermissions;
    }

    public function get_permissions($lang): \Illuminate\Support\Collection
    {

        if ($lang == 'ar') {
            $data = $ar_data = Permission::get(['id', 'name_ar']);
        }
        if ($lang == 'en')
            $data = $en_data = Permission::get(['id', 'name_en']);
        return $data;
    }

    public function assignOrUpdatePermissions(int $user_id, Assign_PermissionRequest $request): array
    {
        $owner = Auth::user();

        if (!$owner || !$owner->pharmacy_owner) {
            throw new \Exception('Owner not found or no pharmacy relation');
        }

        $pharmacyId = $owner->pharmacy_owner->id;

        $permissions = $request->input('permissions');
        if (is_string($permissions)) {
            $permissions = json_decode($permissions, true);
        }
        if (!is_array($permissions)) {
            $permissions = [];
        }

        $pharmacyUser = Pharmacy_User::updateOrCreate(
            [
                'pharmacy_id' => $pharmacyId,
                'user_id' => $user_id,
            ],
            [
                'role' => $request->input('role'),
                'is_work' => true,
            ]
        );

        if (!empty($permissions)) {
            $pharmacyUser->user_pharmacy_permissions()->sync($permissions);
        } else {
            $pharmacyUser->user_pharmacy_permissions()->detach();
        }

        $permissionNames = Permission::whereIn('id', $permissions)
            ->get(['id', 'name_en', 'name_ar']);

        return [
            'user' => $pharmacyUser,
            'permissions_id' => $permissions,
            'permissions_name' => $permissionNames,
        ];
    }

}
