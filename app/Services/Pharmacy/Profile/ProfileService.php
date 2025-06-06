<?php

namespace App\Services\Pharmacy\Profile;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class ProfileService
{
    public function myProfile()
    {
        return Auth::user();


    }

    public function updateProfile(Request $request)
    {
        $user = JWTAuth::user();
        if ($user) {
            $data = User::where('id', $user->id)->update([
                'name' => $request->name,
                'phone_number' => $request->phone_number,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            return $data;
        } else return "Sth got worng!!";

    }

    public function deleteProfile()
    {
        $user = Auth::user();
        if ($user)
            $user->delete();
        return 'success';
    }

}
