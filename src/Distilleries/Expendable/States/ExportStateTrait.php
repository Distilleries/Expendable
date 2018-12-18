<?php namespace Distilleries\Expendable\States;

use \FormBuilder;
use Illuminate\Http\Request;
use Distilleries\Expendable\Exports\BaseExport;

trait ExportStateTrait {

    protected $export_form = 'Distilleries\Expendable\Http\Forms\Export\ExportForm';
    // ------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------

    public function getExport()
    {
        $form = FormBuilder::create($this->export_form, [
            'model' => $this->model
        ]);

        $form_content = view('expendable::admin.form.components.formgenerator.export', [
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

    public function postExport(Request $request)
    {

        $form = FormBuilder::create($this->export_form, [
            'model' => $this->model
        ]);


        if ($form->hasError())
        {
            return $form->validateAndRedirectBack();
        }


        $data = $request->all();
        $filename = $data['range']['start'] . ' ' . $data['range']['end'] . '.' . $data['type'];

        return (new BaseExport($this->model, $data))->download($filename);
    }
} 