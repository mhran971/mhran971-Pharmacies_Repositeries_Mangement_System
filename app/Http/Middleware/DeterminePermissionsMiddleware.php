<?php

namespace App\Http\Middleware;

use App\Models\Pharmacy_User;
use App\Models\Repository_User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class DeterminePermissionsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $hasPermission = false;

        // Check Repository User
        $repoUser = Repository_User::where('user_id', $user->id)->first();
        if ($repoUser) {
            $hasPermission = $repoUser->user_repo_permission()->where('permission_id', 23)->exists();
        }

        // If not, check Pharmacy User
        if (!$hasPermission) {
            $pharmacyUser = Pharmacy_User::where('user_id', $user->id)->first();
            if ($pharmacyUser) {
                $hasPermission = $pharmacyUser->user_pharmacy_permissions()->where('permission_id', 23)->exists();
            }
        }

        if (!$hasPermission) {
            return response()->json(['message' => 'You do not have permission to access this resource.'], 403);
        }

        return $next($request);
    }
}
