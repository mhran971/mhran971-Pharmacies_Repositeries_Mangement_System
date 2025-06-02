<?php

namespace App\Http\Controllers\Pharmacy\Profile;

use App\Http\Controllers\BaseController;
use App\Services\Pharmacy\Profile\ProfileService;
use Illuminate\Http\Request;


class ProfileController extends BaseController
{
    protected ProfileService $profileService;

    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }


    public function get_my_profile(): \Illuminate\Http\JsonResponse
    {
        $data = $this->profileService->myProfile();
        return $this->SendResponse($data, 'Success', 200);

    }

    public function edit_my_profile(Request $request): \Illuminate\Http\JsonResponse
    {
        $data = $this->profileService->updateProfile($request);
        return $this->SendResponse($data, 'Profile Updated Successfully', 200);

    }

    public function delete_my_profile(): \Illuminate\Http\JsonResponse
    {
        $data = $this->profileService->deleteProfile();
        return $this->SendResponse($data, 'Profile Deleted Successfully', 200);

    }
}
