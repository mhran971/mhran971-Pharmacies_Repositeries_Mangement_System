<?php

namespace App\Services\Pharmacy\Auth;

use App\Http\Requests\Pharmacy\Auth\PharmacistRequest;
use App\Http\Requests\Pharmacy\Auth\Pharmacy_OwnerRequest;
use App\Http\Requests\Repository\Auth\LoginRequest;
use App\Models\Pharmacy;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;


class AuthService
{
    public function Pharmacy_Owner_register(Pharmacy_OwnerRequest $request)
    {
        try {
            $user = User::create([
                'name' => $request->name,
                'phone_number' => $request->phone_number,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $pharmacy = Pharmacy::create([
                'pharmacy_name' => $request->pharmacy_name,
                'pharmacy_phone' => $request->pharmacy_phone,
                'pharmacy_address' => $request->pharmacy_address,
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
                'pharmacy' => $pharmacy
            ];
        } catch (\Exception $exception) {
            return response()->json(['error' => 'Registration failed', 'message' => $exception->getMessage()], 500);
        }
    }

    public function Pharmacist_register(PharmacistRequest $request)
    {
        try {
            $user = User::create([
                'name' => $request->name,
                'phone_number' => $request->phone_number,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

//            $pharmacy = Pharmacy::find($request->pharmacy_id);
//            $pharmacy->pharmacists()->attach($user->id);
            $token = JWTAuth::fromUser($user);
            User::query()->where('id', $user->id)->update(['token' => $token]);

            return [
                'user' => $user,
                'authorization' => [
                    'token' => $token,
                    'type' => 'bearer'
                ],
                'pharmacy' => $pharmacy
            ];
        } catch (\Exception $exception) {
            return response()->json(['error' => 'Registration failed', 'message' => $exception->getMessage()], 500);
        }
    }

    public function login(LoginRequest $request)
    {
        if (!$token = JWTAuth::attempt($request->only('email', 'password'))) {
            return 'Unauthorized';
        }

        $user = Auth::user();
        $user->update(['token' => $token]);

        return [
            'user' => $user,
            'authorization' => [
                'token' => $token,
                'type' => 'bearer'
            ]
        ];
    }

    public function logout(): void
    {
        $user = JWTAuth::parseToken()->authenticate(); // أفضل من Auth::user()

        if ($user) {
            $user->update(['token' => null]);
        }

        JWTAuth::invalidate(JWTAuth::getToken());
    }

}
