<?php

namespace App\Services\Repository\Authorization;

use App\Http\Requests\Repository\Authorization\Assign_PermissionRequest;
use App\Models\Permission;
use App\Models\Repository_User;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class RepositoryAuthorizationService
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

    public function assign_permissions(int $user_id, Assign_PermissionRequest $request)
    {
        $permissions = is_array($request->input('permissions'))
            ? $request->input('permissions')
            : json_decode($request->input('permissions'), true);

        $owner = Auth::user();
        if (!$owner)
            return response()->json(['error' => 'no owner founded'], 401);

        $repo = $owner->owner->id;

        $repo_user = Repository_User::firstOrNew([
            'repository_id' => $repo,
            'user_id' => $user_id,
        ]);

        $repo_user->role = $request->input('role');
        $repo_user->is_work = true;
        $repo_user->save();
        $repo_user->refresh();

        if ($repo_user && is_array($permissions)) {
            $repo_user->user_repo_permission()->sync($permissions);
        }

        $permission_names = Permission::whereIn('id', $permissions)->get(['name_en', 'name_ar']);
        $permission_id = Permission::whereIn('id', $permissions)->pluck('id')->toArray();

        return [
            'user' => $repo_user,
            'permissions_id' => $permission_id,
            'permissions_name' => $permission_names,
        ];

    }


}
