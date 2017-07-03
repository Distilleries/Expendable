<?php namespace Distilleries\Expendable\Http\Forms\Import;

use Distilleries\Expendable\Helpers\StaticLabel;
use Distilleries\FormBuilder\FormValidator;

class ImportForm extends FormValidator {

    public static $rules = [
        'file' => 'required'
    ];

    public static $rules_update = null;

    // ------------------------------------------------------------------------------------------------

    public function buildForm()
    {

        $this
            ->add('file', 'upload',
                [
                    'label'      => trans('expendable::form.file_import'),
                    'validation' => 'required',
                    'extensions' => 'csv,xls,xlsx',
                    'view'       => 'files',
                ])
            ->addDefaultActions();
    }
}