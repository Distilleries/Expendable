<?php

namespace Distilleries\Expendable\Http\Middleware;

use Closure;
use Illuminate\Contracts\Foundation\Application;
use Distilleries\Expendable\Helpers\UserUtils;

class SetDisplayStatus {


    protected $app;
    
    /**
     * Create a new filter instance.
     *
     */
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

        if (UserUtils::isBackendRole())
        {
            UserUtils::setDisplayAllStatus();
        } else {
            UserUtils::forgotDisplayAllStatus();
        }

        return $next($request);
    }
}