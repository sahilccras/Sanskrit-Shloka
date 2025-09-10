<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            // If the user is not authenticated, the 'auth' middleware should have already handled it.
            // But as a safeguard, we can redirect to login.
            return redirect('login');
        }

        $user = Auth::user();

        // The 'role' middleware in web.php sometimes uses '|' to separate roles.
        // We need to handle this case by exploding the roles string.
        $allowedRoles = [];
        foreach ($roles as $role) {
            $allowedRoles = array_merge($allowedRoles, explode('|', $role));
        }

        // Trim any whitespace from role names
        $allowedRoles = array_map('trim', $allowedRoles);

        if (!in_array($user->role, $allowedRoles)) {
            // If the user does not have any of the required roles, abort with a 403 error.
            abort(403, 'Unauthorized action. You do not have the required role.');
        }

        return $next($request);
    }
}
