<?php namespace Distilleries\Expendable\Http\Forms\Language;

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
                'empty_value' => '-',
                'validation'  => 'required',
                'label'       => trans('expendable::form.is_visible_for_customer')
            ])
            ->add('is_default', 'choice', [
                'choices'     => StaticLabel::yesNo(),
                'empty_value' => '-',
                'validation'  => 'required',
                'label'       => trans('expendable::form.default_language')
            ])
            ->add('status', 'choice', [
                'choices'     => StaticLabel::status(),
                'empty_value' => '-',
                'validation'  => 'required',
                'label'       => trans('expendable::form.status')
            ]);

        $this->addDefaultActions();
    }

    protected function getUpdateRules()
    {
        $key                  = \Request::get($this->model->getKeyName());
        static::$rules['iso'] = 'required|unique:languages,iso,'.$key;

        return parent::getUpdateRules();
    }
}