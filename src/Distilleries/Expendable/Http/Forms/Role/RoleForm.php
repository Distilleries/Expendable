<?php namespace Distilleries\Expendable\Http\Forms\Role;

use Distilleries\Expendable\Helpers\StaticLabel;
use Distilleries\FormBuilder\FormValidator;

class RoleForm extends FormValidator {

    public static $rules = [
        'libelle'            => 'required',
        'initials'           => 'required|unique:roles',
        'overide_permission' => 'integer'
    ];

    public static $rules_update = [
        'libelle'            => 'required',
        'initials'           => 'required|unique:roles,initials',
        'overide_permission' => 'integer'
    ];

    public function buildForm()
    {
        $this
            ->add('id', 'hidden')
            ->add('libelle', 'text', [
                'validation' => 'required',
                'label'      => trans('expendable::form.libelle')
            ])
            ->add('initials', 'text', [
                'validation' => 'required',
                'label'      => trans('expendable::form.initials')
            ])
            ->add('overide_permission', 'choice', [
                'choices'     => StaticLabel::yesNo(),
                'empty_value' => '-',
                'validation'  => 'required',
                'label'       => trans('expendable::form.allow_automatically_all_permission')
            ]);

        $this->addDefaultActions();
    }

    protected function getUpdateRules()
    {
        $key = \Request::get($this->model->getKeyName());
        static::$rules_update['initials'] = 'required|unique:roles,initials,'.$key;

        return parent::getUpdateRules();
    }
}