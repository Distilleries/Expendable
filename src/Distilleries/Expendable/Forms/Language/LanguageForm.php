<?php namespace Distilleries\Expendable\Forms\Language;

use Distilleries\Expendable\Helpers\StaticLabel;
use Distilleries\FormBuilder\FormValidator;

class LanguageForm extends FormValidator {

    public static $rules = [
        'libelle'     => 'required',
        'iso'         => 'required|unique:languages',
        'not_visible' => 'required|integer',
        'is_default'  => 'required|integer',
        'status'      => 'required|integer'
    ];

    public function buildForm()
    {
        $this
            ->add('id', 'hidden')
            ->add('libelle', 'text')
            ->add('iso', 'text')
            ->add('not_visible', 'choice', [
                'choices'     => StaticLabel::yesNo(),
                'empty_value' => _('-'),
                'validation'  => 'required',
                'label'       => _('Is visible for the customer')
            ])
            ->add('is_default', 'choice', [
                'choices'     => StaticLabel::yesNo(),
                'empty_value' => _('-'),
                'validation'  => 'required',
                'label'       => _('Default Language')
            ])
            ->add('status', 'choice', [
                'choices'     => StaticLabel::status(),
                'empty_value' => _('-'),
                'validation'  => 'required',
                'label'       => _('Status')
            ]);

        $this->addDefaultActions();
    }

    protected function getUpdateRules()
    {
        $key                  = \Input::get($this->model->getKeyName());
        static::$rules['iso'] = 'required|unique:languages,iso,' . $key;

        return parent::getUpdateRules();
    }
}