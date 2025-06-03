<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class OwnerOnly
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if ($user && $user->repoowner()->exists()) {
            return $next($request);
        }

        abort(403, 'Unauthorized: You must be an owner to access this resource.');
    }
}
