<?php namespace Distilleries\Expendable;

use Distilleries\Expendable\Exporter\CsvExporter;
use Distilleries\Expendable\Exporter\ExcelExporter;
use Distilleries\Expendable\Exporter\PdfExporter;
use Distilleries\Expendable\Importer\CsvImporter;
use Distilleries\Expendable\Importer\XlsImporter;
use Distilleries\Expendable\States\StateDisplayer;
use Illuminate\Support\ServiceProvider;
use \File;

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
		$this->package('distilleries/expendable');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{

		$this->app->singleton('Distilleries\MailerSaver\Contracts\MailModelContract', function ($app)
		{
			return new \Email;
		});

		$this->app->singleton('Distilleries\Expendable\Contracts\StateDisplayerContract', function ($app)
		{
			return new StateDisplayer($app['view'],$app['config']);
		});


		$this->registerImporters();
		$this->registerExporters();
		$this->registerCommands();



		include __DIR__.'/../../routes.php';
		include __DIR__.'/../../filters.php';
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
		$files = File::allFiles(__DIR__ . '/Console/');


		foreach ($files as $file)
		{
			if (strpos($file->getPathName(), 'Lib') === false)
			{
				$this->commands('Distilleries\Expendable\Console\\' . preg_replace('/\.php/i', '', $file->getFilename()));
			}


		}
	}


}
