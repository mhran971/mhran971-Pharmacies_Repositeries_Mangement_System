<?php

namespace App\Http\Controllers\Pharmacy\Authorization;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Pharmacy\Authorization\Assign_PermissionRequest;
use App\Models\User;
use App\Services\Pharmacy\Authorization\PharmacyAuthorizationService;
use Illuminate\Http\Request;

class PharmacyAuthorizationController extends BaseController
{
    protected PharmacyAuthorizationService $pharmacyAuthorizationService;

    public function __construct(PharmacyAuthorizationService $pharmacyAuthorizationService)
    {
        $this->pharmacyAuthorizationService = $pharmacyAuthorizationService;
    }
    public function get_all_users()
    {
        $data = $this->pharmacyAuthorizationService->get_users();
        if ($data)
            return $this->sendResponse($data,);
        else
            $this->sendError('Something got wrong');
    }
    public function get_all_permissions($lang)
    {
        $data = $this->pharmacyAuthorizationService->get_permissions($lang);
        if ($data)
            return $this->sendResponse($data,);
        else
            $this->sendError('Something got wrong');
    }

    public function assign_permissions_user($user_id, Assign_PermissionRequest $request): \Illuminate\Http\JsonResponse
    {
        $user = User::findorFail($user_id);
        $data = $this->pharmacyAuthorizationService->assign_permissions($user_id, $request);
        return $this->sendResponse(
            $data,
            "permissions " . implode(',', $data['permissions_id']) . " assigned successfully to {$user->name}"
        );
    }

}
