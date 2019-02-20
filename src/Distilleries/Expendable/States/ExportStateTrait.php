<?php namespace Distilleries\Expendable\States;

use Carbon\Carbon;
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
        $dateStart = !empty($data['range']) && !empty($data['range']['start']) ? $data['range']['start'] : Carbon::now()->format('Y-m-d');
        $dateEnd = !empty($data['range']) && !empty($data['range']['end']) ? $data['range']['end'] : Carbon::now()->format('Y-m-d');
        $type = !empty($data['type']) ? $data['type'] : 'csv';
        $filename = str_replace('/', '-', $dateStart.'_'.$dateEnd).'.'.mb_strtolower($type);

        return (new BaseExport($this->model, $data))->export($filename);
    }
} 