<?php

namespace App\Http\Controllers\Pharmacy\Authorization;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Pharmacy\Authorization\Assign_PermissionRequest;
use App\Models\User;
use App\Services\Pharmacy\Authorization\PharmacyAuthorizationService;

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

    public function My_Pharmacists()
    {
        $data = $this->pharmacyAuthorizationService->get_myPharmacists();
        if ($data)
            return $this->sendResponse($data,);
        else
            $this->sendError('Something got wrong at getting your Pharmacists !');
    }

    public function get_all_permissions($lang)
    {
        $data = $this->pharmacyAuthorizationService->get_permissions($lang);
        if ($data)
            return $this->sendResponse($data,);
        else
            $this->sendError('Something got wrong');
    }

    public function assignOrUpdatePermissions($user_id, Assign_PermissionRequest $request)
    {
        $user = User::findOrFail($user_id);

        $data = $this->pharmacyAuthorizationService->assignOrUpdatePermissions($user_id, $request);

        return $this->sendResponse(
            $data,
            "Permissions " . implode(',', $data['permissions_id']) . " assigned successfully to {$user->name}"
        );
    }


}
