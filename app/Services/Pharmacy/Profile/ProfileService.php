<?php

namespace App\Services\Pharmacy\Profile;


use App\Http\Resources\PharmacyOwnerProfileResource;
use App\Http\Resources\UserProfileResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class ProfileService
{
    public function myProfile()
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        if ($user->pharmacy_owner()->exists()) {
            return new PharmacyOwnerProfileResource($user);
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

        // Check if user is a pharmacy owner
        if ($user->pharmacy_owner()->exists()) {
            $pharmacy = $user->pharmacy_owner;
            $pharmacy->update([
                'pharmacy_name' => $request->pharmacy_name,
                'pharmacy_phone' => $request->pharmacy_phone,
                'pharmacy_address' => $request->pharmacy_address,
            ]);
        }

        User::where('id', $user->id)->update($updateData);
        $user->refresh();

        return $user->pharmacy_owner
            ? new PharmacyOwnerProfileResource($user)
            : new UserProfileResource($user);
    }


    public function deleteProfile()
    {
        $user = Auth::user();
        if ($user)
            $user->delete();
        return 'deleted success';
    }

    

}
