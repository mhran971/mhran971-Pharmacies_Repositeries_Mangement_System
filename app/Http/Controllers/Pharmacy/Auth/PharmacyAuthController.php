<?php

namespace App\Http\Controllers\Pharmacy\Auth;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Pharmacy\Auth\PharmacistRequest;
use App\Http\Requests\Pharmacy\Auth\Pharmacy_OwnerRequest;
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
}
