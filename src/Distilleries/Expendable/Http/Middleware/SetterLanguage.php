<?php

namespace Distilleries\Expendable\Http\Middleware;

use Closure;

class SetterLanguage
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

        if ($request->session()->has('language')) {
            $local = $request->session()->get('language', config('app.locale'));
            app()->setLocale($local);
        }

        return $next($request);
    }
}