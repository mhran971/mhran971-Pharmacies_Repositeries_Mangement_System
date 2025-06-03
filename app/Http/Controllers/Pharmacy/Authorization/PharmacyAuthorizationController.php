<?php

namespace App\Http\Controllers\Pharmacy\Authorization;

use App\Http\Controllers\BaseController;
use App\Services\Pharmacy\Authorization\PharmacyAuthorizationService;

class PharmacyAuthorizationController extends BaseController
{
    protected PharmacyAuthorizationService $pharmacyAuthorizationService;

    public function __construct(PharmacyAuthorizationService $pharmacyAuthorizationService)
    {
        $this->pharmacyAuthorizationService = $pharmacyAuthorizationService;
    }

    public function get_all_permissions($lang)
    {
        $data = $this->pharmacyAuthorizationService->get_permissions($lang);
        if ($data)
            return $this->sendResponse($data,);
        else
            $this->sendError('Something got wrong');
    }

}
