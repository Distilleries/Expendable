<?php namespace Distilleries\Expendable;

use Distilleries\Expendable\Exporter\CsvExporter;
use Distilleries\Expendable\Exporter\ExcelExporter;
use Distilleries\Expendable\Exporter\PdfExporter;
use Distilleries\Expendable\Importer\CsvImporter;
use Distilleries\Expendable\Importer\XlsImporter;
use Distilleries\Expendable\Layouts\LayoutManager;
use Distilleries\Expendable\Models\Email;
use Distilleries\Expendable\Models\User;
use Distilleries\Expendable\States\StateDisplayer;
use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;

class ExpendableServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../../views', 'expendable');
        $this->loadTranslationsFrom(__DIR__ . '/../../lang', 'expendable');
        $this->publishes([
            __DIR__ . '/../../config/config.php'    => config_path('expendable.php'),
            __DIR__ . '/../../database/migrations/' => base_path('/database/migrations'),
            __DIR__ . '/../../database/seeds/'      => base_path('/database/seeds'),
        ]);
        $this->publishes([
            __DIR__ . '/../../views' => base_path('resources/views/vendor/expendable'),
        ], 'views');
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/config.php', 'expendable'
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

        $this->app->singleton('Distilleries\MailerSaver\Contracts\MailModelContract', function()
        {
            return new Email;
        });

        $this->alias();
        $this->registerCommands();
        $this->registerImporters();
        $this->registerExporters();


    }

    protected function registerImporters()
    {
        $this->app->singleton('CsvImporterContract', function()
        {
            return new CsvImporter;
        });

        $this->app->singleton('XlsImporterContract', function()
        {
            return new XlsImporter;
        });

        $this->app->singleton('XlsxImporterContract', function()
        {
            return new XlsImporter;
        });
    }

    protected function registerExporters()
    {

        $this->app->singleton('Distilleries\Expendable\Contracts\CsvExporterContract', function()
        {
            return new CsvExporter;
        });
        $this->app->singleton('Distilleries\Expendable\Contracts\ExcelExporterContract', function()
        {
            return new ExcelExporter;
        });


    }


    protected function registerCommands()
    {
        $file  = app('files');
        $files = $file->allFiles(__DIR__ . '/Console/');

        foreach ($files as $file)
        {
            if (strpos($file->getPathName(), 'Lib') === false)
            {
                $this->commands('Distilleries\Expendable\Console\\' . preg_replace('/\.php/i', '', $file->getFilename()));
            }
        }
    }

    public function provides()
    {
        return [
            'Distilleries\Expendable\Contracts\StateDisplayerContract',
            'Distilleries\Expendable\Contracts\LayoutManagerContract',
            'Distilleries\MailerSaver\Contracts\MailModelContract',
            'CsvImporterContract',
            'XlsImporterContract',
            'XlsxImporterContract',
            'Distilleries\Expendable\Contracts\CsvExporterContract',
            'Distilleries\Expendable\Contracts\ExcelExporterContract',
            'Distilleries\Expendable\Contracts\PdfExporterContract',
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