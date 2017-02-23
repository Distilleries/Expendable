<?php

abstract class ExpendableTestCase extends \Orchestra\Testbench\BrowserKit\TestCase
{

    protected $facade;

    protected function initService()
    {
        $service       = $this->app->getProvider('Distilleries\Expendable\ExpendableServiceProvider');
        $this->facades = $service->provides();
        $service->boot();
        $service->register();

        return $service;
    }

    /**
     * Resolve application implementation.
     *
     * @return \Illuminate\Foundation\Application
     */
    protected function resolveApplication()
    {
        $app = new \Distilleries\Expendable\Fondation\Application($this->getBasePath());
        $app->bind('Illuminate\Foundation\Bootstrap\LoadConfiguration', 'Orchestra\Testbench\Bootstrap\LoadConfiguration');

        return $app;
    }


    public function setUp()
    {
        parent::setUp();
        $this->app['Illuminate\Contracts\Console\Kernel']->call('vendor:publish');
        $this->artisan('migrate');

    }

    protected function resolveApplicationHttpKernel($app)
    {
        $app->singleton('Illuminate\Contracts\Http\Kernel', 'Distilleries\Expendable\Http\Kernel');
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('auth.providers.users.model', Distilleries\Expendable\Models\User::class);
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
    }


    protected function getPackageProviders($app)
    {
        return [
            'Distilleries\FormBuilder\FormBuilderServiceProvider',
            'Distilleries\DatatableBuilder\DatatableBuilderServiceProvider',
            'Distilleries\PermissionUtil\PermissionUtilServiceProvider',
            'Maatwebsite\Excel\ExcelServiceProvider',
            'Distilleries\Expendable\ExpendableServiceProvider',
            'Distilleries\Expendable\ExpendableRoutingServiceProvider',
            'Distilleries\Expendable\ExpendableRouteServiceProvider'
            
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
            'Password'       => 'Illuminate\Support\Facades\Password',
            'FormBuilder'    => 'Distilleries\FormBuilder\Facades\FormBuilder',
            'Form'           => 'Collective\Html\FormFacade',
            'HTML'           => 'Collective\Html\HtmlFacade',
            'Datatable'      => 'Distilleries\DatatableBuilder\Facades\DatatableBuilder',
            'PermissionUtil' => 'Distilleries\PermissionUtil\Facades\PermissionUtil',
            'Excel'          => 'Maatwebsite\Excel\Facades\Excel',
        ];
    }
}