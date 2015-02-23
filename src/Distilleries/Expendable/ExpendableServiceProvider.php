<?php namespace Distilleries\Expendable;

use Distilleries\Expendable\Exporter\CsvExporter;
use Distilleries\Expendable\Exporter\ExcelExporter;
use Distilleries\Expendable\Exporter\PdfExporter;
use Distilleries\Expendable\Importer\CsvImporter;
use Distilleries\Expendable\Importer\XlsImporter;
use Distilleries\Expendable\Layouts\LayoutManager;
use Distilleries\Expendable\Models\Email;
use Distilleries\Expendable\States\StateDisplayer;
use Illuminate\Support\ServiceProvider;

class ExpendableServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../../views', 'expendable');
        $this->loadTranslationsFrom(__DIR__.'/../../lang', 'expendable');
        $this->publishes([
            __DIR__.'/../../config/config.php'    => config_path('expendable.php'),
            __DIR__.'/../../database/migrations/' => base_path('/database/migrations'),
            __DIR__.'/../../database/seeds/'      => base_path('/database/seeds'),
        ]);
        $this->publishes([
            __DIR__.'/../../views' => base_path('resources/views/vendor/expendable'),
        ], 'views');
        $this->mergeConfigFrom(
            __DIR__.'/../../config/config.php', 'expendable'
        );
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {

        $this->app->singleton('Distilleries\Expendable\Contracts\StateDisplayerContract', function ($app)
        {
            return new StateDisplayer($app['view'], $app['config']->get('expendable'));
        });

        $this->app->singleton('Distilleries\Expendable\Contracts\LayoutManagerContract', function ($app)
        {
            return new LayoutManager($app['config']->get('expendable'), $app['view'], $app['files'], app('Distilleries\Expendable\Contracts\StateDisplayerContract'));
        });

        $this->app->singleton('Distilleries\MailerSaver\Contracts\MailModelContract', function ($app)
        {
            return new Email;
        });

        $this->registerCommands();
        $this->registerImporters();
        $this->registerExporters();

    }

    protected function registerImporters()
    {
        $this->app->singleton('CsvImporterContract', function ($app)
        {
            return new CsvImporter;
        });

        $this->app->singleton('XlsImporterContract', function ($app)
        {
            return new XlsImporter;
        });

        $this->app->singleton('XlsxImporterContract', function ($app)
        {
            return new XlsImporter;
        });
    }

    protected function registerExporters()
    {

        $this->app->singleton('Distilleries\Expendable\Contracts\CsvExporterContract', function ($app)
        {
            return new CsvExporter;
        });
        $this->app->singleton('Distilleries\Expendable\Contracts\ExcelExporterContract', function ($app)
        {
            return new ExcelExporter;
        });
        $this->app->singleton('Distilleries\Expendable\Contracts\PdfExporterContract', function ($app)
        {
            return new PdfExporter;
        });

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
}