<?php namespace Distilleries\Expendable\Forms\Export;

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
                    'label'      => _('Date'),
                    'validation' => 'required',
                    'range'      => true
                ])
            ->add('type', 'choice', [
                'choices'    => StaticLabel::typeExport(),
                'validation' => 'required',
                'label'      => _('Type')
            ])
            ->addDefaultActions();
    }


    // ------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------

}