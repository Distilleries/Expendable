<?php

namespace Distilleries\Expendable\Http\Middleware;

use Closure;
use Illuminate\Contracts\Foundation\Application;

class Secure {

    protected $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if (!$request->isSecure() and env('SECURE_COOKIE', false)) {
            if (strpos($request->getRequestUri(), '/storage/') === false) {
                return redirect()->secure($request->getRequestUri());
            }

        }

        return $next($request);
    }
}