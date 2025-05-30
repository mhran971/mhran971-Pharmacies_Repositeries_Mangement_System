<?php

namespace App\Http\Controllers\Repository\Auth;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Repository\Auth\EmployeeRequest;
use App\Http\Requests\Repository\Auth\Repo_OwnerRequest;
use App\Services\Repository\Auth\AuthService;


class RepositoryAuthController extends BaseController
{
    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function Repo_Owner_registering(Repo_OwnerRequest $request): \Illuminate\Http\JsonResponse
    {
        $data = $this->authService->Repo_Owner_register($request);

        if (empty($data)) {
            return response()->json(['error' => 'Registration failed'], 406);
        }
        return $this->SendResponse($data, 'Success', 200);

    }

    public function Employee_registering(EmployeeRequest $request): \Illuminate\Http\JsonResponse
    {
        $data = $this->authService->Employee_register($request);

        if (empty($data)) {
            return response()->json(['error' => 'Registration failed'], 406);
        }
        return $this->SendResponse($data, 'Success', 200);

    }
}
