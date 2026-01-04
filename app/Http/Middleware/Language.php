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

            // Only process locale-based redirects if segment exists and could be a locale
            if ($segment && array_key_exists($segment, config('app.locales'))) {
                // First segment is a valid locale, set it as the app locale
                Config::set('app.locale', $segment);
                App::setLocale($segment);
                Session::put('locale', $segment);
            } elseif ($segment && !in_array($segment, ['admin', 'vendor', 'api', 'client'])) {
                // Only prepend locale if the first segment is not a known route prefix
                // This prevents redirect loops for routes like /admin, /vendor, etc.
                $locale = App::getLocale();
                $locales = array_keys(config('app.locales', []));
                
                // Only redirect if we have valid locales configured and current segment is not a locale
                if (!empty($locales) && !in_array($segment, $locales)) {
                    $segments = $request->segments();
                    // Use array_merge instead of deprecated array_prepend
                    $segments = array_merge([$locale], $segments);
                    
                    return redirect()->to('/' . implode('/', $segments));
                }
            }
        }

        return $next($request);
    }
}