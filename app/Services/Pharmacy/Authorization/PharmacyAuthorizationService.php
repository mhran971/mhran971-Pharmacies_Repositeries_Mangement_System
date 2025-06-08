<?php

namespace App\Services\Pharmacy\Authorization;

use App\Http\Requests\Pharmacy\Authorization\Assign_PermissionRequest;
use App\Models\Permission;
use App\Models\Pharmacy_User;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class PharmacyAuthorizationService
{
    public function get_users(): array
    {
        $allUsers = [];

        User::chunk(100, function ($usersChunk) use (&$allUsers) {
            foreach ($usersChunk as $user) {
                $allUsers[] = $user->name;
            }
        });

        return $allUsers;
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
    public function assign_permissions(int $user_id, Assign_PermissionRequest $request): \Illuminate\Http\JsonResponse|array
    {
        $permissions = is_array($request->input('permissions'))
            ? $request->input('permissions')
            : json_decode($request->input('permissions'), true);

        $owner = Auth::user();
        if (!$owner)
            return response()->json(['error' => 'no owner founded'], 401);

        if (!$owner->pharmacy_owner) {
            return response()->json(['error' => 'owner relation not found'], 401);
        }

        $pharmacy = $owner->pharmacy_owner->id;

        $pharmacy_user = Pharmacy_User::firstOrNew([
            'pharmacy_id' => $pharmacy,
            'user_id' => $user_id,
        ]);

        $pharmacy_user->role = $request->input('role');
        $pharmacy_user->is_work = true;
        $pharmacy_user->save();
        $pharmacy_user->refresh();

        if ($pharmacy_user && is_array($permissions)) {
            $pharmacy_user->user_pharmacy_permission()->sync($permissions);
        }

        $permission_names = Permission::whereIn('id', $permissions)->get(['name_en', 'name_ar']);
        $permission_id = Permission::whereIn('id', $permissions)->pluck('id')->toArray();

        return [
            'user' => $pharmacy_user,
            'permissions_id' => $permission_id,
            'permissions_name' => $permission_names,
        ];

    }
}
