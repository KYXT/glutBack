<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class LanguageMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $locale = $request->header('Content-Language');

        if (!$locale){
            $locale = config('app.locale');
        }

        if (in_array($locale, config('app.supported_locales'))) {
            App::setLocale($locale);

            return $next($request);
        }

        abort(403, 'Language not supported.');
    }
}
