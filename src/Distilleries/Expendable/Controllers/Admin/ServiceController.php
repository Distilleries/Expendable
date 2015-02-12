<?php


namespace Distilleries\Expendable\Controllers\Admin;

use Illuminate\Support\Facades\Redirect;
use \Service, \File, \App, \ReflectionClass, \ReflectionMethod;
use Distilleries\Expendable\Contracts\StateDisplayerContract;
use Distilleries\Expendable\Controllers\AdminBaseComponent;
use Distilleries\Expendable\Datatables\Service\ServiceDatatable;
use Distilleries\Expendable\Forms\Service\ServiceForm;


class ServiceController extends AdminBaseComponent {

    protected $escape = [
        'callAction',
        'setFilterer',
        'getFilterer',
        'getAfterFilters',
        'getBeforeFilters',
        'forgetAfterFilter',
        'forgetBeforeFilter',
        'afterFilter',
        'beforeFilter',
        'addToLayout',
        'missingMethod',
    ];

    public function __construct(Service $model, StateDisplayerContract $stateProvider, ServiceDatatable $datatable, ServiceForm $form)
    {
        parent::__construct($model, $stateProvider);
        $this->datatable = $datatable;
        $this->form      = $form;
    }


    // ------------------------------------------------------------------------------------------------

    public function getSynchronize()
    {
        $controllers = File::allFiles(app_path() . '/controllers');

        foreach ($controllers as $controller)
        {
            $object = App::make(preg_replace('/\.php/', '', $controller->getRelativePathname()));

            $relflection = new ReflectionClass($object);
            foreach ($relflection->getMethods(ReflectionMethod::IS_PUBLIC) as $methode)
            {
                if (substr($methode->name, 0, 2) != '__' and !in_array($methode->name, $this->escape))
                {
                    $service       = $relflection->getName() . '@' . $methode->name;
                    $serviceObject = $this->model->getByAction($service);

                    if ($serviceObject->isEmpty())
                    {
                        $model         = new $this->model;
                        $model->action = $service;
                        $model->save();
                    }
                }
            }
        }

        return Redirect::back();
    }

    // ------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------


}