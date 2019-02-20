<?php namespace Distilleries\Expendable\Http\Controllers\Backend;

use Distilleries\Expendable\Contracts\LayoutManagerContract;
use Distilleries\Expendable\Http\Forms\Permission\PermissionForm;
use Distilleries\Expendable\Http\Controllers\Backend\Base\ModelBaseController;
use Distilleries\Expendable\States\FormStateTrait;
use Illuminate\Http\Request;
use Distilleries\Expendable\Models\Permission;
use Distilleries\FormBuilder\Contracts\FormStateContract;
use \FormBuilder;

class PermissionController extends ModelBaseController  implements FormStateContract {

    use FormStateTrait;

    public function __construct(PermissionForm $form, Permission $model, LayoutManagerContract $layoutManager)
    {
        parent::__construct($model, $layoutManager);
        $this->form = $form;
    }


    // ------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------

    public function getIndex()
    {
        return redirect()->to(action('\\'.get_class($this).'@getEdit'));
    }

    // ------------------------------------------------------------------------------------------------

    public function postEdit(Request $request)
    {

        $form = FormBuilder::create(get_class($this->form), [
            'model' => $this->model
        ]);

        if ($form->hasError())
        {
            return $form->validateAndRedirectBack();
        }

        $permissions = $request->get('permission');
        $this->model->truncate();


        foreach ($permissions as $role_id=>$permission) {

            foreach ($permission as $service_id) {
                $permModel = new $this->model;
                $permModel->role_id = $role_id;
                $permModel->service_id = $service_id;
                $permModel->save();
            }
        }


        return redirect()->to(action('\\'.get_class($this).'@getIndex'));

    }
}