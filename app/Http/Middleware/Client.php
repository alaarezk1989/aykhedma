<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Laravel\Passport\Exceptions\MissingScopeException;
use Laravel\Passport\Http\Middleware\CheckClientCredentials as Middleware;

class Client extends Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @param  mixed  ...$scopes
     *
     * @return mixed
     * @throws AuthenticationException
     * @throws MissingScopeException
     */
    public function handle($request, Closure $next, ...$scopes)
    {
        auth()->setDefaultDriver('api');
        $request->headers->set('Authorization', $request->headers->get('Auth', ''));

        return parent::handle($request, $next, ...$scopes);
    }
}
