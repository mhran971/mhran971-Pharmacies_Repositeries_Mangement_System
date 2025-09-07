<?php

namespace App\Services\Pharmacy\Auth;

use App\Http\Requests\Pharmacy\Auth\PharmacistRequest;
use App\Http\Requests\Pharmacy\Auth\Pharmacy_OwnerRequest;
use App\Http\Requests\Repository\Auth\LoginRequest;
use App\Http\Resources\UserLoginResource;
use App\Models\Pharmacy;
use App\Models\User;
use App\Services\GeneralServices\NotificationService;
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
                'role_id' => 2,
                'mac_token' => $request->mac_token,
            ]);

            $pharmacy = Pharmacy::create([
                'pharmacy_name' => $request->pharmacy_name,
                'pharmacy_phone' => $request->pharmacy_phone,
                'pharmacy_address' => $request->pharmacy_address,
                'owner_id' => $user->id,
            ]);

            $token = JWTAuth::fromUser($user);
            User::query()->where('id', $user->id)->update(['token' => $token]);
            $notificationService = new NotificationService();
            $notificationService->send($user->mac_token, "Hi {$user->name} ", "Welcome in our application");

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
                'role_id' => 4,
                'mac_token' => $request->mac_token,
            ]);

//            $pharmacy = Pharmacy::find($request->pharmacy_id);
//            $pharmacy->pharmacists()->attach($user->id);
            $token = JWTAuth::fromUser($user);
            User::query()->where('id', $user->id)->update(['token' => $token]);
            $notificationService = new NotificationService();
            $notificationService->send($user->mac_token, "Hi {$user->name} ", "Welcome in our application", "Welcome to our application");
            return [
                'user' => $user,
                'authorization' => [
                    'token' => $token,
                    'type' => 'bearer'
                ],
//                'pharmacy' => $pharmacy
            ];
        } catch (\Exception $exception) {
            return response()->json(['error' => 'Registration failed', 'message' => $exception->getMessage()], 500);
        }
    }

    public function login(LoginRequest $request)
    {
        if (!$token = JWTAuth::attempt($request->only('email', 'password'))) {
            return abort_if($token, 404, 'user not founded');
        }

        $user = Auth::user();
        $user->update(['token' => $token]);

        return [
            'user' => new UserLoginResource($user),
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
