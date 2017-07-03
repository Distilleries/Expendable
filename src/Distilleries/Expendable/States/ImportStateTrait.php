<?php namespace Distilleries\Expendable\States;

use Distilleries\Expendable\Formatter\Message;
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
        $file = urldecode(preg_replace('/\/app\//', '', $file));

        if (!app('files')->exists($file))
        {
            return redirect()->back()->with(Message::WARNING, [trans('expendable::errors.file_not_found')]);
        }

        $contract = ucfirst(app('files')->extension($file)) . 'ImporterContract';
        $exporter = app($contract);
        $data     = $exporter->getArrayDataFromFile($file);

        foreach ($data as $item)
        {
            $primary = isset($item[$this->model->getKeyName()]) ? $item[$this->model->getKeyName()] : '';
            if (empty($primary))
            {
                $this->model = new $this->model;
                $this->model = $this->model->create($item);
            } else
            {
                $this->model = $this->model->find($primary);
                $this->model->update($item);
            }

        }

        return redirect()->back()->with(Message::MESSAGE, [trans('expendable::success.imported')]);

    }
} 