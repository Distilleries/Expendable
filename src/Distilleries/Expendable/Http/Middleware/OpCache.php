<?php

namespace VanksenTaskManager\Http\Middleware;

use Closure;
use Illuminate\Contracts\Foundation\Application;

class OpCache
{
    protected $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if (($this->app->environment() != 'production')) {
            if (function_exists('opcache_reset')) {
                opcache_reset();
            }

        }

        return $next($request);
    }
}