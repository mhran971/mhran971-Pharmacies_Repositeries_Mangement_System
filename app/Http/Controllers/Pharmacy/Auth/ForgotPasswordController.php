<?php

namespace App\Http\Controllers\Pharmacy\Auth;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\Pharmacy\Auth\ForgotPasswordRequest;
use Illuminate\Support\Facades\Hash;
use App\Mail\PasswordResetCodeMail;
use Illuminate\Support\Facades\Mail;
use App\Models\VerificationCode;

class ForgotPasswordController extends BaseController
{
    public function forgotPassword(ForgotPasswordRequest $request){
        $emailExist = User::where('email', $request->email)->first();
        if(!$emailExist){
            return response()->json(['error' => 'Invalid code'], 422);
        }
        $code = mt_rand(100000, 999999);
        $user = VerificationCode::updateOrCreate(
            ['email' => $request->email],
            ['code' => $code,
             'created_at' => now()]
        );

        Mail::to($request->email)
            ->queue(new PasswordResetCodeMail($code, 5));
        return response()->json([
            'message' => 'Verification code sent to your email',
            'expires_in' => 300 // 5 minutes in seconds
        ]);

    }

    public function verifyCode(ForgotPasswordRequest $request){
        $record = VerificationCode::where('email', $request->email)
            ->where('code', $request->code)
            ->first();

        if (!$record) {
            return response()->json(['error' => 'Invalid code'], 422);
        }
        if ($record->updated_at->addMinutes(185)->isPast()) {
            return response()->json(['error' => 'Code expired'], 422);
        }

        return response()->json([
            'message' => 'Code verified',
        ]);
    }

    public function resetPassword(Request $request){
        $validated = $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:8|confirmed'
        ]);
        if ($validated){
            $reset = User::where('email', $request->email)->update([
            'password' => Hash::make($request->password),
            ]);
            if($reset){
                return response()->json([
                    'message' => 'Password has been reset successfully'
                ]);
            }
        }
        return response()->json([
            'error' => 'Invalid password'
        ]);



    }
}
