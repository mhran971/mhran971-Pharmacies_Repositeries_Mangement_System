<?php

namespace App\Http\Controllers\Repository\Profile;

use App\Http\Controllers\BaseController;
use App\Services\Repository\RepoProfile\RepoProfileService;
use Illuminate\Http\Request;

class RepoProfileController extends BaseController
{
    protected RepoProfileService $repoProfileService;

    public function __construct(RepoProfileService $repoProfileService)
    {
        $this->repoProfileService = $repoProfileService;
    }


    public function get_my_profile(): \Illuminate\Http\JsonResponse
    {
        $data = $this->repoProfileService->myProfile();
        return $this->SendResponse($data, 'Success', 200);

    }

    public function edit_my_profile(Request $request): \Illuminate\Http\JsonResponse
    {
        $data = $this->repoProfileService->updateProfile($request);
        return $this->SendResponse($data, 'Profile Updated Successfully', 200);

    }

    public function delete_my_profile(): \Illuminate\Http\JsonResponse
    {
        $data = $this->repoProfileService->deleteProfile();
        return $this->SendResponse($data, 'Profile Deleted Successfully', 200);

    }
}
