<?php

class ConsoleTest extends ExpendableTestCase {

    public function testConsoleMakeComponentNoParams()
    {
        $this->app['Illuminate\Contracts\Console\Kernel']->call('expendable:component.make', [
            'name' => 'TestController',
        ]);

        $file = $this->app['path'].'/TestController.php';
        require_once($file);

        $this->assertFileExists($file);
        File::delete($file);
    }

    public function testConsoleMakeComponentWithStates()
    {
        $this->app['Illuminate\Contracts\Console\Kernel']->call('expendable:component.make', [
            'name'     => 'TestStateController',
            "--states" => '\Distilleries\DatatableBuilder\Contracts\DatatableStateContract,\Distilleries\Expendable\Contracts\ExportStateContract'
        ]);

        $file = $this->app['path'].'/TestStateController.php';
        require_once($file);

        $this->assertFileExists($file);
        File::delete($file);
    }


    public function testConsoleMakeComponentWithStatesAndModelAndFormAndDatatable()
    {
        $this->app['Illuminate\Contracts\Console\Kernel']->call('expendable:component.make', [
            'name'        => 'TestStatesAndModelAndFormAndDatatableController',
            "--states"    => '\Distilleries\DatatableBuilder\Contracts\DatatableStateContract,\Distilleries\Expendable\Contracts\ExportStateContract,\Distilleries\Expendable\Contracts\ImportStateContract,\Distilleries\FormBuilder\Contracts\FormStateContract',
            "--model"     => 'App\Email',
            "--datatable" => "TestDatatable",
            "--form"      => "TestForm"
        ]);

        $file = $this->app['path'].'/TestStatesAndModelAndFormAndDatatableController.php';
        require_once($file);

        $this->assertFileExists($file);
        File::delete($file);
    }


    public function testConsoleMakeComponentWithStatesAndModel()
    {
        $this->app['Illuminate\Contracts\Console\Kernel']->call('expendable:component.make', [
            'name'     => 'TestStateAndModelController',
            "--states" => '\Distilleries\Expendable\Contracts\ExportStateContract',
            "--model"  => 'App\Email',
        ]);

        $file = $this->app['path'].'/TestStateAndModelController.php';
        require_once($file);

        $this->assertFileExists($file);
        File::delete($file);
    }


    public function testConsoleMakeComponentWithTemplate()
    {
        $this->app['Illuminate\Contracts\Console\Kernel']->call('expendable:component.make', [
            'name'       => 'TestTemplateController',
            "--template" => 'controller-base-class-template'
        ]);

        $file = $this->app['path'].'/TestTemplateController.php';
        require_once($file);

        $this->assertFileExists($file);
        File::delete($file);
    }
}

use Distilleries\DatatableBuilder\EloquentDatatable;

class TestDatatable extends EloquentDatatable {

    public function build()
    {
        // Add fields here...

        $this->addDefaultAction();

    }
}

use Distilleries\FormBuilder\FormValidator;

class TestForm extends FormValidator {

    public static $rules = [];
    public static $rules_update = null;

    public function buildForm()
    {
        // Add fields here...

        $this->addDefaultActions();
    }
}