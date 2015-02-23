<?php namespace Distilleries\Expendable\Http\Controllers\Admin;

use Distilleries\Expendable\Contracts\LayoutManagerContract;
use Distilleries\Expendable\Datatables\Service\ServiceDatatable;
use Distilleries\Expendable\Forms\Service\ServiceForm;
use Distilleries\Expendable\Http\Controllers\Admin\Base\BaseComponent;
use Distilleries\Expendable\Models\Service;
use Illuminate\Contracts\Routing\Registrar;
use ReflectionClass;
use ReflectionMethod;

class ServiceController extends BaseComponent {

    public function __construct(ServiceDatatable $datatable, ServiceForm $form, Service $model, LayoutManagerContract $layoutManager)
    {
        parent::__construct($model, $layoutManager);
        $this->datatable = $datatable;
        $this->form      = $form;
    }


    // ------------------------------------------------------------------------------------------------

    public function getSynchronize(Registrar $router)
    {

        $routes = $router->getRoutes();

        foreach ($routes->getRoutes() as $controller)
        {
            $actions       = $controller->getAction();

            if(!empty($actions['controller'])){
                $service       = $actions['controller'];
                $serviceObject = $this->model->getByAction($service);

                if ($serviceObject->isEmpty())
                {
                    $model         = new $this->model;
                    $model->action = $service;
                    $model->save();
                }
            }


        }

        return redirect()->back();
    }
}