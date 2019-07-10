<?php

namespace Distilleries\Expendable;

use Distilleries\Expendable\Layouts\LayoutManager;
use Distilleries\Expendable\Models\User;
use Distilleries\Expendable\States\StateDisplayer;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;

class ExpendableServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {

        $this->loadViewsFrom(__DIR__.'/../../views', 'expendable');
        $this->loadTranslationsFrom(__DIR__.'/../../lang', 'expendable');
        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations/');


        $this->publishes([
            __DIR__.'/../../config/config.php'    => config_path('expendable.php'),
            __DIR__.'/../../database/seeds/'      => base_path('/database/seeds'),
        ]);


        $this->publishes([
            __DIR__.'/../../views' => base_path('resources/views/vendor/expendable'),
        ], 'views');
        $this->mergeConfigFrom(
            __DIR__.'/../../config/config.php', 'expendable'
        );

        $autoLoaderListener = new \Distilleries\Expendable\Register\ListenerAutoLoader(config('expendable.listener'));
        $autoLoaderListener->load();

    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('Distilleries\Expendable\Contracts\LockableContract', function($app)
        {
            return new User;
        });

        $this->app->singleton('Distilleries\Expendable\Contracts\StateDisplayerContract', function($app)
        {
            return new StateDisplayer($app['view'], $app['config']->get('expendable'));
        });

        $this->app->singleton('Distilleries\Expendable\Contracts\LayoutManagerContract', function($app)
        {
            return new LayoutManager($app['config']->get('expendable'), $app['view'], $app['files'], app('Distilleries\Expendable\Contracts\StateDisplayerContract'));
        });

        $this->alias();
        $this->registerCommands();
    }

    protected function registerCommands()
    {
        $file  = app('files');
        $files = $file->allFiles(__DIR__.'/Console/');

        foreach ($files as $file)
        {
            if (strpos($file->getPathName(), 'Lib') === false)
            {
                $this->commands('Distilleries\Expendable\Console\\'.preg_replace('/\.php/i', '', $file->getFilename()));
            }
        }
    }

    public function provides()
    {
        return [
            'Distilleries\Expendable\Contracts\StateDisplayerContract',
            'Distilleries\Expendable\Contracts\LayoutManagerContract',
            'Distilleries\Expendable\Contracts\ImportContract',
            'Distilleries\Expendable\Contracts\ExportContract',
        ];
    }


    public function alias()
    {

        AliasLoader::getInstance()->alias(
            'Excel',
            'Maatwebsite\Excel\Facades\Excel'
        );
    }
}