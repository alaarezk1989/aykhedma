<?php

namespace App\Http\Middleware;

use Closure;
use App;
use Config;
use Session;
use Illuminate\Http\Request;

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

        if ($request->getMethod() === 'GET') {
            $segment = $request->segment(1);

            if ($segment && array_key_exists($segment, config('app.locales'))) {
                // First segment is a valid locale, set it as the app locale
                Config::set('app.locale', $segment);
                App::setLocale($segment);
                Session::put('locale', $segment);
            } elseif (!in_array($segment, ['api', 'client'])) {
                // Segment is missing or not a known prefix, prepend locale
                $locale = App::getLocale();
                $locales = array_keys(config('app.locales', []));
                
                // Only redirect if we have valid locales configured
                if (!empty($locales)) {
                    $segments = $request->segments();
                    $segments = array_merge([$locale], $segments);
                    
                    return redirect()->to('/' . implode('/', $segments));
                }
            }
        }

        return $next($request);
    }
}