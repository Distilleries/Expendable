<?php


namespace Distilleries\Expendable\States;

use \View, \FormBuilder, \Input, \Redirect, \App;

trait ExportStateTrait {

    protected $export_form = 'Distilleries\Expendable\Forms\Export\ExportForm';
    // ------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------

    public function getExport()
    {
        $form = FormBuilder::create($this->export_form, [
            'model' => $this->model
        ]);

        $form_content = View::make('expendable::admin.form.components.formgenerator.export', [
            'form' => $form
        ]);
        $content      = View::make('expendable::admin.form.state.form', [

        ]);

        $this->addToLayout($form_content, 'form');
        $this->addToLayout($content, 'content');
    }

    // ------------------------------------------------------------------------------------------------

    public function postExport()
    {

        $form = FormBuilder::create($this->export_form, [
            'model' => $this->model
        ]);


        if ($form->hasError())
        {
            return $form->validateAndRedirectBack();
        }


        $data = Input::all();

        foreach ($data['range'] as $key => $date)
        {
            $data['range'][$key] = date('Y-m-d', strtotime($date));
        }

        $result = $this->model->betweenCreate($data['range']['start'], $data['range']['end'])->get();

        if (!$result->isEmpty())
        {
            $exporter = App::make($data['type']);
            $file     = $exporter->export($result->toArray(),$data['range']['start'].' '.$data['range']['end']);

            return $file;
        }

        return Redirect::to(action(get_class($this) . '@getExport'));

    }
} 