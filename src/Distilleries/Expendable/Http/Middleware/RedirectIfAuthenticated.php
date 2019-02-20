<?php 

namespace Distilleries\Expendable\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Routing\Registrar;
use Illuminate\Http\RedirectResponse;

class RedirectIfAuthenticated {

    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;
    protected $router;
    protected $config;

    /**
     * Create a new filter instance.
     *
     * @param  Guard $auth
     */
    public function __construct(Guard $auth, Registrar $router, Repository $config)
    {
        $this->auth   = $auth;
        $this->router = $router;
        $this->config = $config;
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
        if ($this->auth->check() && $this->router->current()->getActionName() != $this->config->get('expendable.logout_action'))
        {
            $menu = $this->config->get('expendable.menu');
            $user = $this->auth->user();

            if (method_exists($user, 'getFirstRedirect') && !empty($menu) && !empty($menu['left']))
            {
                return new RedirectResponse($this->auth->user()->getFirstRedirect($menu['left']));
            }

            return new RedirectResponse('/');

        }

        return $next($request);
    }
}