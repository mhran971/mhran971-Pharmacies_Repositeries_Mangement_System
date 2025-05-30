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
        try {
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
            User::query()->where('id', $user->id)->update(['token' => $token]);

            return [
                'user' => $user,
                'authorization' => [
                    'token' => $token,
                    'type' => 'bearer'
                ],
                'repository' => $repository
            ];
        } catch (\Exception $exception) {
            return response()->json(['error' => 'Registration failed', 'message' => $exception->getMessage()], 500);
        }
    }

    public function Employee_register(EmployeeRequest $request)
    {
        try {
            $user = User::create([
                'name' => $request->name,
                'phone_number' => $request->phone_number,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $repository = Repository::find($request->repository_id);
            $repository->Employees()->attach($user->id);

            $token = JWTAuth::fromUser($user);
            User::query()->where('id', $user->id)->update(['token' => $token]);

            return [
                'user' => $user,
                'authorization' => [
                    'token' => $token,
                    'type' => 'bearer'
                ],
                'repository' => $repository
            ];
        } catch (\Exception $exception) {
            return response()->json(['error' => 'Registration failed', 'message' => $exception->getMessage()], 500);
        }
    }
}
