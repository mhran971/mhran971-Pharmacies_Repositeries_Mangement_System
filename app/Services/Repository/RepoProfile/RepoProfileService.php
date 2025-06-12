<?php

namespace App\Services\Repository\RepoProfile;


use App\Http\Resources\RepoOwnerProfileResource;
use App\Http\Resources\repositoryOwnerProfileResource;
use App\Http\Resources\UserProfileResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class RepoProfileService
{
    public function myProfile()
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        if ($user->repoowner()->exists()) {
            return new RepoOwnerProfileResource($user);
        }

        return new UserProfileResource($user);
    }


    public function updateProfile(Request $request)
    {
        $user = JWTAuth::user();

        if (!$user) return response()->json(['message' => 'Something went wrong!'], 400);

        $updateData = [
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        if ($user->repoowner()->exists()) {
            $repo = $user->repoowner;
            $repo->update([
                'repository_name' => $request->repository_name,
                'repository_phone' => $request->repository_phone,
                'repository_address' => $request->repository_address,
            ]);
        }

        User::where('id', $user->id)->update($updateData);
        $user->refresh();

        return $user->repoowner
            ? new RepoOwnerProfileResource($user)
            : new UserProfileResource($user);
    }


    public function deleteProfile()
    {
        $user = Auth::user();
        $user->delete();
        return 'deleted success';
    }

}
