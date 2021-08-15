<?php

namespace App\Http\Middleware;

use Closure;
use App;
use Config;
use Symfony\Component\HttpFoundation\Request;

class PreSerialize
{
    public function handle(Request $request, Closure $next)
    {
        $availableLocales = Config::get('app.locales');

        if ($request->headers->has('Accept-Language') &&
            array_key_exists($request->headers->get('Accept-Language'), $availableLocales)) {
            App::setLocale($request->headers->get('Accept-Language'));
        } else {
            App::setLocale(Config::get('app.fallback_locale'));
        }

        return $next($request);
    }
}
