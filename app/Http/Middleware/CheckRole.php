<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle(Request $request, Closure $next, String $role)
    {
        if(!$request->user()->hasRole($role)){            
            return abort(404);
        }
        return $next($request);
    }
}
