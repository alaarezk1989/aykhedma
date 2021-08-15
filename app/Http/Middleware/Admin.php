<?php

namespace App\Http\Middleware;

use App\Constants\UserTypes;
use Closure;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $request->headers->set('Authorization', $request->headers->get('Auth'));
        $userTypes = UserTypes::ADMIN;
        if (auth()->user()) {
            if (auth()->user()->type != $userTypes) {
                return redirect('/login');
            }
            return $next($request);
        }
        return redirect('/login');
    }
}
