<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // $role = explode('|', $role);

        // if (!$request->user()->hasRole($role)) {
        //     return response()->json(['message' => 'You cannot access this page! You are not ' . $role]);
        // }

        // return $next($request);

        foreach ($roles as $role) {
            if ($request->user()->hasRole($role)) {
                //At least one role passes
                return $next($request);
            }
        }

        return response()->json(['message' => 'You cannot access this page!']);
    }
}
