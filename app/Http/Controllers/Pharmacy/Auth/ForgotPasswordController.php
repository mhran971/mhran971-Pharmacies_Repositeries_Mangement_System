<?php

namespace App\Http\Controllers\Pharmacy\Auth;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Pharmacy\Auth\ForgotPasswordRequest;
use App\Mail\SendCodeResetPassword;
use App\Models\User;
use App\Models\VerificationCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends BaseController
{
    public function forgotPassword(ForgotPasswordRequest $request){
        $emailExist = User::where('email', $request->email)->first();
        if(!$emailExist){
            return response()->json(['error' => 'Invalid email'], 422);
        }
        $code = mt_rand(100000, 999999);
        $user = VerificationCode::updateOrCreate(
            ['email' => $request->email],
            ['code' => $code,
                'created_at' => now()]
        );

//        Mail::to($request->email)
//            ->queue(new PasswordResetCodeMail($code, 5));
        if ($user) {
            Mail::to($request->email)->send(new SendCodeResetPassword($code));
            return response()->json([
                'message' => 'Verification code sent to your email',
                'expires_in' => '5 minutes'
            ]);
        } else {
            return response()->json([
                'message' => 'Verification code not sent to your email'
            ]);

       }
    }

    public function verifyCode(Request $request)
    {
        $record = VerificationCode::where('email', $request->email)
            ->where('code', $request->code)
            ->first();

        if (!$record) {
            return response()->json(['error' => 'Invalid code'], 422);
        }
        if ($record->updated_at->addMinutes(5)->isPast()) {
            return response()->json(['error' => 'Code expired'], 422);
        }

        return response()->json([
            'message' => 'Code verified',
        ]);
    }

    public function resetPassword(Request $request){
        $validated = $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:8|'
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
