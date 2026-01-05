<?php


if (! function_exists('route')) {
    /**
     * Generate the URL to a named route.
     *
     * @param  array|string  $name
     * @param  mixed  $parameters
     * @param  bool  $absolute
     * @return string
     */
    function route($name, $parameters = [], $absolute = true)
    {
        if (! is_array($parameters)) {
            $parameters = [app()->getLocale(), $parameters];
        } elseif (! isset($parameters['lang'])) {
            $locales = array_keys(config('app.locales', []));
            if (! isset($parameters[0]) || ! in_array($parameters[0], $locales)) {
                $parameters = array_merge(['lang' => app()->getLocale()], $parameters);

                if (count(array_filter(array_keys($parameters), 'is_string')) < count($parameters)) {
                    $parameters = array_values($parameters);
                }
            }
        }

        return app('url')->route($name, $parameters, $absolute);
    }
}

if (! function_exists('trans')) {
    /**
     * Translate the given message.
     *
     * @param  string  $key
     * @param  array   $replace
     * @param  string  $locale
     * @return \Illuminate\Contracts\Translation\Translator|string|array|null
     */
    function trans($key = null, $replace = [], $locale = null)
    {
        if (is_null($key)) {
            return app('translator');
        }

        if (!(strpos($key, '.') !== false)) {
            $key = 'translations.'.$key;
        }

        return app('translator')->get($key, $replace, $locale);
    }
}


if (!function_exists('code')) {
    /**
     * @param int $numbers
     * @param string $type
     * @return bool|string
     */
    function code($numbers = 6, $type = 'mixed')
    {
        $type = (in_array($type, ['digits', 'mixed', 'characters'])) ? $type : 'mixed';
        $digits = '0123456789';
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $mixed = $digits . $characters;
        return substr(str_shuffle($$type), 1, $numbers);
    }
}

if (!function_exists('uniqueCode')) {
    /**
     * @param int $numbers
     * @param string $type
     * @param Model $model
     * @return bool|string
     */
    function uniqueCode($numbers = 6, $type = 'mixed')
    {
        $code = code($numbers, $type);
        while (\App\Models\Voucher::where('code', $code)->count() || \App\Models\Coupon::where('code', $code)->count()) {
            $code = code($numbers, $type);
        }
        return $code;
    }
}
