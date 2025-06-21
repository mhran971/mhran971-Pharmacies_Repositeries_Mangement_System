<?php

namespace App\Services\Pharmacy\Auth;

use App\Http\Requests\Pharmacy\Auth\ForgotPasswordRequest;
use App\Models\User;
use App\Models\VerificationCode;
use Ramsey\Uuid\Type\Integer;


class forgotPassword
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {

    }

    public function generateCode(ForgotPasswordRequest $request)
    {

        ForgotPasswordRequest::where('email', $request->email)->delete();

        $code = Integer::random(6);

        $codeData = VerificationCode::create([
            'email' => $request->email,
            'code' => $code,
            'created_at' => now()
        ]);

        return $code;
    }


    public function validateCode(ForgotPasswordRequest $request)
    {
        $checkCode = VerificationCode::where('email', $request->email)
            ->where('code', $request->code)
            ->first();

        if (!$checkCode) {
            return false;
        }

        if ($checkCode->created_at->addSeconds(60)->isPast()) {
            return false;
        }

        return true;
    }

    public function sendCodeToEmail(ForgotPasswordRequest $request)
    {

        $code = generateCode($request);
        try {
        Mail::to($request->email)->queue((new PasswordResetCodeMail($code))->onQueue('emails'));

            return response()->json(['message' => 'sending code done'], 200);
        }catch (Exception $e) {
            return response()->json(['error' => 'sending code failed', 'message' => $e->getMessage()], 500);
        }
    }

}
