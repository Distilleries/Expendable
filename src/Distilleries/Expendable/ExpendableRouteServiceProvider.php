<?php namespace Distilleries\Expendable;

use Distilleries\Expendable\Http\Router\Router;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class ExpendableRouteServiceProvider extends ServiceProvider
{

    protected $router;
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'Distilleries\Expendable\Http\Controllers';



    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapWebRoutes();

        $this->mapApiRoutes();

        //
    }



    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {

        $this->registerRouter();

    }


    protected function registerRouter(){

        $this->app['router'] = $this->app->share(function($app)
        {
            $router = new Router($app['events'], $app);
         
            return $router;
        });
    }


    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {

        \Route::group([
            'middleware' => 'web',
            'namespace'  => $this->namespace,
        ], function ($router) {

            require __DIR__ . '/../routes/web.php';
        });
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        \Route::group([
            'middleware' => 'api',
            'namespace'  => $this->namespace,
            'prefix'     => 'api',
        ], function ($router) {
            require __DIR__ . '/../routes/api.php';
        });
    }
}
