<?php


namespace Distilleries\Expendable\States;

use Distilleries\Expendable\Formatter\Message;
use \View, \FormBuilder, \Input, \Redirect, \Lang, \File, \App;

trait ImportStateTrait {

    protected $import_form = 'Distilleries\Expendable\Forms\Import\ImportForm';
    // ------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------

    public function getImport()
    {
        $form = FormBuilder::create($this->import_form, [
            'model' => $this->model
        ]);

        $form_content = View::make('expendable::admin.form.components.formgenerator.import', [
            'form' => $form
        ]);
        $content      = View::make('expendable::admin.form.state.form', [

        ]);

        $this->addToLayout($form_content, 'form');
        $this->addToLayout($content, 'content');
    }

    // ------------------------------------------------------------------------------------------------

    public function postImport()
    {

        $form = FormBuilder::create($this->import_form, [
            'model' => $this->model
        ]);


        if ($form->hasError())
        {
            return $form->validateAndRedirectBack();
        }


        $file = Input::get('file');
        $file = urldecode(app_path(preg_replace('/\/app\//', '', $file)));

        if (!File::exists($file))
        {
            return Redirect::back()->with(Message::WARNING, [Lang::get('expendable::errors.file_not_found')]);
        }

        $contract = ucfirst(File::extension($file)) . 'ImporterContract';
        $exporter = App::make($contract);
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

        return Redirect::back()->with(Message::MESSAGE, [Lang::get('expendable::success.imported')]);

    }
} 