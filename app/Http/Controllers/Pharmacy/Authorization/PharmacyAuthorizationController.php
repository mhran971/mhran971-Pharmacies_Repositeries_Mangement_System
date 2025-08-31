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
    public function get_MyPermissions()
    {
        $data = $this->pharmacyAuthorizationService->MyPermissions();
        if ($data)
            return $this->sendResponse($data,);
        else
            $this->sendError('Something got wrong at getting your Permissions !');
    }
    public function delete_MyPharmacists($id)
    {
        $data = $this->pharmacyAuthorizationService->delete_MyPharmacists($id);
        if ($data)
            return $this->sendResponse($data);

        else
            $this->sendError('Something got wrong while deleting your Pharmacists !');
    }
    public function My_Pharmacists()
    {
        $data = $this->pharmacyAuthorizationService->get_myPharmacists();
        if ($data)
            return $this->sendResponse($data,);
        else
            $this->sendError('Something got wrong at getting your Pharmacists !');
    }
    public function My_Pharmacist_Permissions($id)
    {
        $data = $this->pharmacyAuthorizationService->get_Pharmacist_permissions_perId($id);
        if ($data)
            return $this->sendResponse($data,);
        else
            $this->sendError('Something got wrong at getting your Pharmacists Permissions !');
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
