<?php

namespace App\Services\Pharmacy\Auth;

use App\Http\Requests\Pharmacy\Auth\PharmacistRequest;
use App\Http\Requests\Pharmacy\Auth\Pharmacy_OwnerRequest;
use App\Models\Pharmacy;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AuthService
{
    public function Pharmacy_Owner_register(Pharmacy_OwnerRequest $request)
    {
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

        Auth::login($user);
        return [
            'user' => $user,
            'pharmacy' => $pharmacy
        ];
    }

    public function Pharmacist_register(PharmacistRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $pharmacy = Pharmacy::find($request->pharmacy_id);
        $pharmacy->pharmacists()->attach($user->id);

        Auth::login($user);
        return [
            'user' => $user,
            'pharmacy' => $pharmacy
        ];
    }
}
