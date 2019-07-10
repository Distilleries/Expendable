<?php namespace Distilleries\Expendable\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\AuthenticateWithBasicAuth;

class AuthenticateOnceWithBasicAuth extends AuthenticateWithBasicAuth {


    /**
     * Handle an incoming request.
     * @param \Illuminate\Http\Request $request
     * @param Closure $next
     * @param null $guard
     * @param null $field
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null, $field = null)
    {
        $ipsAuth = env('BASIC_AUTH_IP', '');
        $ipsAuth = explode(',', $ipsAuth);


        if (env('BASIC_AUTH', false) == true)
        {
            if (empty($ipsAuth) || !in_array($request->ip(), $ipsAuth))
            {
                return $this->auth->guard($guard)->basic() ?: $next($request);
            }

        }

        return $next($request);
    }

}