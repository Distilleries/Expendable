<?php


namespace Distilleries\Expendable\Controllers\Admin;


use Distilleries\Expendable\Contracts\FormStateContract;
use Distilleries\Expendable\Contracts\StateDisplayerContract;
use Distilleries\Expendable\Controllers\AdminBaseController;
use Distilleries\Expendable\Formatter\Message;
use Distilleries\Expendable\Forms\Component\ComponentForm;
use \View, \FormBuilder, \Input, \Redirect, \Artisan, \Lang;

class ComponentController extends AdminBaseController implements FormStateContract {


    public function __construct(StateDisplayerContract $stateProvider, ComponentForm $form)
    {
        parent::__construct($stateProvider);
        $this->form = $form;
    }



    // ------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------

    public function getIndex()
    {
        return Redirect::to(action(get_class($this) . '@getEdit'));
    }


    // ------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------

    public function getEdit($id = '')
    {

        $form = FormBuilder::create(get_class($this->form));


        $form_content = View::make('expendable::admin.form.components.formgenerator.full', [
            'form' => $form
        ]);
        $content      = View::make('expendable::admin.form.state.form', [

        ]);

        $this->addToLayout($form_content, 'form');
        $this->addToLayout($content, 'content');

    }

    // ------------------------------------------------------------------------------------------------

    public function postEdit()
    {

        $form = FormBuilder::create(get_class($this->form));


        if ($form->hasError())
        {
            return $form->validateAndRedirectBack();
        }

        $libelle            = Input::get('libelle');
        $libelle_form       = $libelle . 'Form';
        $libelle_datatable  = $libelle . 'Datatable';
        $libelle_controller = $libelle . 'Controller';
        $model              = Input::get('models');
        $states             = Input::get('state');


        foreach ($states as $state)
        {
            if (strpos($state, 'DatatableStateContract') !== false)
            {

                Artisan::call('datatable:make', [
                    '--fields' => Input::get('colon_datatable'),
                    'name'     => app_path() . '/Datatables/' . $libelle_datatable
                ]);
            } else if (strpos($state, 'FormStateContract') !== false)
            {

                Artisan::call('form:make', [
                    '--fields' => Input::get('fields_form'),
                    'name'     => app_path() . '/Forms/' . $libelle_form
                ]);
            }
        }


        Artisan::call('component:make', [
            '--states'    => join(',', $states),
            '--model'     => $model,
            '--datatable' => $libelle_datatable,
            '--form'      => $libelle_form,
            'name'        => app_path() . '/controllers/Admin/' . $libelle_controller
        ]);

        return Redirect::back()->with(Message::MESSAGE, [Lang::get('expendable::success.generated')]);

    }


}