<?php namespace Distilleries\Expendable\States;

use Distilleries\Expendable\Formatter\Message;
use Distilleries\Expendable\Imports\BaseImport;
use Illuminate\Http\Request;
use \View, \FormBuilder, \Input, \Redirect, \Lang, \File, \App;

trait ImportStateTrait {

    protected $import_form = 'Distilleries\Expendable\Http\Forms\Import\ImportForm';

    // ------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------

    public function getImport()
    {
        $form = FormBuilder::create($this->import_form, [
            'model' => $this->model
        ]);

        $form_content = view('expendable::admin.form.components.formgenerator.import', [
            'form' => $form
        ]);
        $content      = view('expendable::admin.form.state.form', [

        ]);

        $this->layoutManager->add([
        'form'=>$form_content,
        'content'=>$content,
        ]);

        return $this->layoutManager->render();
    }

    // ------------------------------------------------------------------------------------------------

    public function postImport(Request $request)
    {

        $form = FormBuilder::create($this->import_form, [
            'model' => $this->model
        ]);


        if ($form->hasError())
        {
            return $form->validateAndRedirectBack();
        }


        $file = $request->get('file');
        $file = urldecode($file);
        if (!app('files')->exists($file))
        {
            return redirect()->back()->with(Message::WARNING, [trans('expendable::errors.file_not_found')]);
        }
        $file = str_replace(storage_path('app/'), '', $file);

        (new BaseImport($this->model))->importFromFile($file);

        return redirect()->back()->with(Message::MESSAGE, [trans('expendable::success.imported')]);

    }
} 