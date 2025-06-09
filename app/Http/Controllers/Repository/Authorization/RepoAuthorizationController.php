<?php

namespace App\Http\Controllers\Repository\Authorization;

use App\Http\Controllers\BaseController;

use App\Http\Requests\Repository\Authorization\Assign_PermissionRequest;
use App\Models\User;
use App\Services\Repository\Authorization\RepositoryAuthorizationService;
use Illuminate\Http\Request;

class RepoAuthorizationController extends BaseController
{
    protected RepositoryAuthorizationService $repositoryAuthorizationService;


    public function __construct(RepositoryAuthorizationService $repositoryAuthorizationService)
    {
        $this->repositoryAuthorizationService = $repositoryAuthorizationService;
    }
    public function get_all_users()
    {
        $data = $this->repositoryAuthorizationService->get_users();
        if ($data)
            return $this->sendResponse($data,);
        else
            $this->sendError('Something got wrong');
    }
    public function get_all_permissions($lang)
    {
        $data = $this->repositoryAuthorizationService->get_permissions($lang);
        if ($data)
            return $this->sendResponse($data,);
        else
            $this->sendError('Something got wrong');
    }

    public function assign_permissions_user($user_id, Assign_PermissionRequest $request)
    {
        $user = User::findorFail($user_id);
        $data = $this->repositoryAuthorizationService->assign_permissions($user_id, $request);
        return $this->sendResponse(
            $data,
            "permissions " . implode(',', $data['permissions_id']) . " assigned successfully to {$user->name}"
        );
    }

}
