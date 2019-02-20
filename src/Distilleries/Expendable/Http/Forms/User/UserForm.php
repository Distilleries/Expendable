<?php namespace Distilleries\Expendable\Http\Forms\User;

use Distilleries\Expendable\Helpers\StaticLabel;
use Distilleries\Expendable\Models\Role;
use Distilleries\FormBuilder\FormValidator;

class UserForm extends FormValidator {

    public static $rules = [
        'email'    => 'required|email|unique:users',
        'password' => 'required|min:8',
        'status'   => 'required|integer',
        'role_id'  => 'required|integer',
    ];

    public static $rules_update = [
        'id'      => 'required',
        'email'   => 'required|email|unique:users,email',
        'status'  => 'required|integer',
        'role_id' => 'required|integer',
    ];

    // ------------------------------------------------------------------------------------------------


    public function buildForm()
    {

        $this
            ->add($this->model->getKeyName(), 'hidden')
            ->add('email', 'email',
                [
                    'label'      => trans('expendable::form.email'),
                    'validation' => 'required,custom[email]',
                ]);

        $id = $this->model->getKey();

        if (!empty($id))
        {
            $this->add('change_password', 'checkbox', [
                'default_value' => 1,
                'label'         => trans('expendable::form.change_password_help'),
                'checked'       => false,
                'noInEditView'  => true
            ]);
        }

        $this->add('password', 'password',
            [
                'label'        => trans('expendable::form.password'),
                'attr'         => ['id' => 'password'],
                'validation'   => 'required',
                'noInEditView' => true
            ])
            ->add('password_match', 'password',
                [
                    'label'        => trans('expendable::form.repeat_password'),
                    'validation'   => 'required,equals[password]',
                    'noInEditView' => true
                ])
            ->add('status', 'choice', [
                'choices'     => StaticLabel::status(),
                'empty_value' => '-',
                'validation'  => 'required',
                'label'       => trans('expendable::form.status')
            ])
            ->add('role_id', 'choice', [
                'choices'     => Role::getChoice(),
                'empty_value' => '-',
                'validation'  => 'required',
                'label'       => trans('expendable::form.role')
            ])
            ->addDefaultActions();
    }

    protected function getUpdateRules()
    {
        $key                           = \Request::get($this->model->getKeyName());
        static::$rules_update['email'] = 'required|email|unique:users,email,'.$key;

        return parent::getUpdateRules();
    }
}