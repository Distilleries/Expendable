<?php namespace Distilleries\Expendable\Http\Forms\Export;

use Distilleries\Expendable\Helpers\StaticLabel;
use Distilleries\FormBuilder\FormValidator;

class ExportForm extends FormValidator {

    public static $rules = [
        'range' => 'required',
        'type'  => 'required'
    ];

    public static $rules_update = null;

    // ------------------------------------------------------------------------------------------------

    public function buildForm()
    {

        $this
            ->add('range', 'datepicker',
                [
                    'label'      => trans('expendable::form.date'),
                    'validation' => 'required',
                    'range'      => true
                ])
            ->add('type', 'choice', [
                'choices'    => StaticLabel::typeExport(),
                'validation' => 'required',
                'label'      => trans('expendable::form.type')
            ])
            ->addDefaultActions();
    }
}