<?php

namespace App\Http\Middleware;

use App\Http\Resources\DefaultResource;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if (strpos($request->url(), "/api/") !== false) {
            return $request->expectsJson() ? null : route('unauthorized');
        } else {
            // if(auth()->user()) {
            //     $roles = auth()->user->roles->pluck('name')->toArray();
            //     if (in_array('admin',$roles) || in_array('school', $roles)) {
            //         return route('dashboard');
            //     }else {
            //         auth()->logout();
            //         return route('login');
            //     }
            // }
            return $request->expectsJson() ? null : route('login');
        }
    }
}
