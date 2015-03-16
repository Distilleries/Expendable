<?php


abstract class ExpendableTestCase extends \Orchestra\Testbench\TestCase {


    protected $facade;

    protected function initService()
    {
        $service       = $this->app->getProvider('Distilleries\Expendable\ExpendableServiceProvider');
        $this->facades = $service->provides();
        $service->boot();
        $service->register();

        return $service;
    }

    public function setUp()
    {
        parent::setUp();
        $this->app['Illuminate\Contracts\Console\Kernel']->call('vendor:publish');
        $this->artisan('migrate', [
            '--database' => 'testbench',
            '--realpath' => realpath(__DIR__.'/../src/database/migrations'),
        ]);

    }

    protected function resolveApplicationHttpKernel($app)
    {
        $app->singleton('Illuminate\Contracts\Http\Kernel', 'Distilleries\Expendable\Http\Kernel');
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('auth.model', 'Distilleries\Expendable\Models\User');
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', array(
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ));
    }


    protected function getPackageProviders()
    {
        return [
            'Distilleries\MailerSaver\MailerSaverServiceProvider',
            'Distilleries\FormBuilder\FormBuilderServiceProvider',
            'Distilleries\DatatableBuilder\DatatableBuilderServiceProvider',
            'Distilleries\PermissionUtil\PermissionUtilServiceProvider',
            'Maatwebsite\Excel\ExcelServiceProvider',
            'Distilleries\Expendable\ExpendableServiceProvider',
            'Distilleries\Expendable\ExpendableRouteServiceProvider',
        ];
    }

    protected function getPackageAliases()
    {
        return [
            'Mail'           => 'Distilleries\MailerSaver\Facades\Mail',
            'FormBuilder'    => 'Distilleries\FormBuilder\Facades\FormBuilder',
            'Form'           => 'Illuminate\Html\FormFacade',
            'HTML'           => 'Illuminate\Html\HtmlFacade',
            'Datatable'      => 'Distilleries\DatatableBuilder\Facades\DatatableBuilder',
            'PermissionUtil' => 'Distilleries\PermissionUtil\Facades\PermissionUtil',
            'Excel'          => 'Maatwebsite\Excel\Facades\Excel',
        ];
    }
}

