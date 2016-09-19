<?php

namespace Distilleries\Expendable\Http\Middleware;

use Closure;

class Cache
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
        if (config('cache.enabled') === true) {
            $url = $request->url();

            $key = md5($url . json_encode($request->query()));
            $value = \Cache::remember($key, config('cache.minutes'), function () use ($next, $request) {
                return $next($request);
            });

            return $value;
        }

        return $next($request);
    }
}