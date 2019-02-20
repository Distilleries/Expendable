<?php namespace Distilleries\Expendable\Http\Controllers\Backend;

use Distilleries\Expendable\Contracts\LayoutManagerContract;
use Distilleries\Expendable\Formatter\Message;
use Distilleries\Expendable\Http\Forms\Component\ComponentForm;
use Distilleries\Expendable\Http\Controllers\Backend\Base\BaseController;
use Distilleries\FormBuilder\Contracts\FormStateContract;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Http\Request;
use \FormBuilder;

class ComponentController extends BaseController implements FormStateContract {

    protected $artisan;

    public function __construct(Kernel $artisan, ComponentForm $form, LayoutManagerContract $layoutManager)
    {
        parent::__construct($layoutManager);
        $this->form    = $form;
        $this->artisan = $artisan;
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


        $form_content = view('form-builder::form.components.formgenerator.full', [
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

        foreach ($states as $state)
        {
            if (strpos($state, 'DatatableStateContract') !== false)
            {
                $this->artisan->call('datatable:make', [
                    '--fields' => $request->get('colon_datatable'),
                    'name'     => 'Http/Datatables/'.$libelle_datatable
                ]);
            } else if (strpos($state, 'FormStateContract') !== false)
            {

                $this->artisan->call('make:form', [
                    '--fields' => $request->get('fields_form'),
                    'name'     => 'Http/Forms/'.$libelle_form
                ]);
            }
        }

        $this->artisan->call('expendable:component.make', [
            '--states'    => join(',', $states),
            '--model'     => $model,
            '--datatable' => $libelle_datatable,
            '--form'      => $libelle_form,
            'name'        => 'Http/Controllers/Backend/'.$libelle_controller
        ]);

        return redirect()->back()->with(Message::MESSAGE, [trans('expendable::success.generated')]);
    }
}