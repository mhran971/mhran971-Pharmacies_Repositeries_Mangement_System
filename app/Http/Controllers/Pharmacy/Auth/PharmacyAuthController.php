<?php

namespace App\Http\Controllers\Pharmacy\Auth;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Pharmacy\Auth\PharmacistRequest;
use App\Http\Requests\Pharmacy\Auth\Pharmacy_OwnerRequest;
use App\Http\Requests\Repository\Auth\LoginRequest;
use App\Services\Pharmacy\Auth\AuthService;

class PharmacyAuthController extends BaseController
{
    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function Pharmacy_owner_registering(Pharmacy_OwnerRequest $request): \Illuminate\Http\JsonResponse
    {
        $data = $this->authService->Pharmacy_Owner_register($request);

        if (empty($data)) {
            return $this->sendError('registration has failed!');
        }
        return $this->sendResponse($data, 'Success', 200);
    }

    public function Pharmacist_registration(PharmacistRequest $request): \Illuminate\Http\JsonResponse
    {
        $data = $this->authService->Pharmacist_register($request);
        if (empty($data)) {
            return $this->sendError('registration has failed!');
        }
        return $this->sendResponse($data, 'success', 200);
    }

    public function login(LoginRequest $request): \Illuminate\Http\JsonResponse
    {
        $data = $this->authService->login($request);

        if (empty($data)) {
            return response()->json(['error' => 'login failed'], 406);
        }
        return $this->SendResponse($data, 'Success', 200);

    }

    public function logout(): \Illuminate\Http\JsonResponse
    {
        $this->authService->logout();

        return $this->SendResponse("logout successfully", 'Success', 200);

    }
}
