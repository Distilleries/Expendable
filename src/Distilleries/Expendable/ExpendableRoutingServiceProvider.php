<?php namespace Distilleries\Expendable;

use Distilleries\Expendable\Http\Router\Router;
use Illuminate\Routing\RoutingServiceProvider;

class ExpendableRoutingServiceProvider extends RoutingServiceProvider
{

    /**
     * Register the router instance.
     *
     * @return void
     */
    protected function registerRouter()
    {
        $this->app->singleton('router', function($app) {
            return new Router($app['events'], $app);
        });
    }
}
