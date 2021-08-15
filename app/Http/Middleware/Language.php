<?php

namespace App\Http\Middleware;

use Closure;
use App;
use Config;
use Session;
use Symfony\Component\HttpFoundation\Request;

class Language
{
    public function handle(Request $request, Closure $next)
    {

        if (Session::has('locale') AND array_key_exists(Session::get('locale'), Config::get('app.locales'))) {
            App::setLocale(Session::get('locale'));
        }
        else {
            App::setLocale(Config::get('app.fallback_locale'));
        }

        if ($request->method() === 'GET') {
            $segment = $request->segment(1);

            if (!array_key_exists($segment, config('app.locales'))) {

                $segments = $request->segments();
                $segments = array_prepend($segments, App::getLocale());

                return redirect()->to(implode('/', $segments));
            }

            Config::set('app.locale', $segment);
            App::setLocale($segment);
            Session::put('locale', $segment);
        }

        return $next($request);
    }
}