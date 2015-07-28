<?php namespace Distilleries\Expendable\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\AuthenticateWithBasicAuth;

class AuthenticateOnceWithBasicAuth extends AuthenticateWithBasicAuth {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        return $this->auth->basic() ?: $next($request);
    }

}