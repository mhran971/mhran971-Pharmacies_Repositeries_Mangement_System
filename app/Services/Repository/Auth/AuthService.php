<?php

namespace App\Services\Repository\Auth;

use App\Http\Requests\Repository\Auth\EmployeeRequest;
use App\Http\Requests\Repository\Auth\Repo_OwnerRequest;
use App\Models\Repository;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;


class AuthService
{
    public function Repo_Owner_register(Repo_OwnerRequest $request): array
    {
        $user = User::create([
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $repository = Repository::create([
            'repository_name' => $request->repository_name,
            'repository_phone' => $request->repository_phone,
            'repository_address' => $request->repository_address,
            'owner_id' => $user->id,
        ]);

        $token = JWTAuth::fromUser($user);
        return [
            'user' => $user,
            'authorization' => [
                'token' => $token,
                'type' => 'bearer'
            ],
            'repository' => $repository
        ];
    }

    public function Employee_register(EmployeeRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $repository = Repository::find($request->repository_id);
        $repository->Employees()->attach($user->id);

        $token = JWTAuth::fromUser($user);
        return [
            'user' => $user,
            'authorization' => [
                'token' => $token,
                'type' => 'bearer'
            ],
            'repository' => $repository
        ];
    }
}
