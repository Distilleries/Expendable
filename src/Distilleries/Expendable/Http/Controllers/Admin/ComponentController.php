<?php namespace Distilleries\Expendable\Http\Controllers\Admin;


use Distilleries\Expendable\Contracts\LayoutManagerContract;
use Distilleries\Expendable\Formatter\Message;
use Distilleries\Expendable\Forms\Component\ComponentForm;
use Distilleries\Expendable\Http\Controllers\Admin\Base\BaseController;
use Distilleries\FormBuilder\Contracts\FormStateContract;
use Illuminate\Http\Request;
use \Artisan;

class ComponentController extends BaseController implements FormStateContract {


    public function __construct(LayoutManagerContract $layoutManager, ComponentForm $form)
    {
        parent::__construct($layoutManager);
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
    // ------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------

    public function getEdit($id = '')
    {

        $form = FormBuilder::create(get_class($this->form));


        $form_content = view('expendable::admin.form.components.formgenerator.full', [
            'form' => $form
        ]);
        $content      = view('expendable::admin.form.state.form', [

        ]);

        $this->layoutManager->add([
            'form'    => $form_content,
            'content' => $content,
        ]);

        return $this->layoutManager->render();
    }

    // ------------------------------------------------------------------------------------------------

    public function postEdit(Request $request)
    {

        $form = FormBuilder::create(get_class($this->form));

        if ($form->hasError())
        {
            return $form->validateAndRedirectBack();
        }

        $libelle            = $request->get('libelle');
        $libelle_form       = $libelle.'Form';
        $libelle_datatable  = $libelle.'Datatable';
        $libelle_controller = $libelle.'Controller';
        $model              = $request->get('models');
        $states             = $request->get('state');
        $namespace          = '\\'.$request->get('source_path').'\\';
        $source_path        = $request->get('source_path');
        $source_path        = app_path().'/'.(!empty($source_path) ? $namespace.'/' : '');


        foreach ($states as $state)
        {
            if (strpos($state, 'DatatableStateContract') !== false)
            {
                Artisan::call('expendable:datatable.make', [
                    '--fields' => $request->get('colon_datatable'),
                    'name'     => $source_path.'Datatables/'.$libelle_datatable
                ]);
            } else if (strpos($state, 'FormStateContract') !== false)
            {

                Artisan::call('expendable:form.make', [
                    '--fields' => $request->get('fields_form'),
                    'name'     => $source_path.'Forms/'.$libelle_form
                ]);
            }
        }


        Artisan::call('expendable:component.make', [
            '--states'    => join(',', $states),
            '--model'     => $model,
            '--datatable' => $namespace.'Datatables\\'.$libelle_datatable,
            '--form'      => $namespace.'Forms\\'.$libelle_form,
            'name'        => app_path().'/controllers/Admin/'.$libelle_controller
        ]);

        return redirect()->back()->with(Message::MESSAGE, [trans('expendable::success.generated')]);
    }
}