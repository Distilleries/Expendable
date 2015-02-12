<?php namespace Distilleries\Expendable\Forms\User;

use Distilleries\Expendable\Helpers\StaticLabel;
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
                    'label'      => _('Email'),
                    'validation' => 'required,custom[email]',
                ]);

        $id = $this->model->getKey();

        if (!empty($id))
        {
            $this->add('change_password', 'checkbox', [
                'default_value' => 1,
                'label'         => _('Check it if you want change your password'),
                'checked'       => false,
                'noInEditView'  => true
            ]);
        }

        $this->add('password', 'password',
            [
                'label'      => _('Password'),
                'attr'       => ['id'=>'password'],
                'validation' => 'required',
                'noInEditView'  => true
            ])
            ->add('password_match', 'password',
                [
                    'label'      => _('Repeat Password'),
                    'validation' => 'required,equals[password]',
                    'noInEditView'  => true
                ])
            ->add('status', 'choice', [
                'choices'     => StaticLabel::status(),
                'empty_value' => _('-'),
                'validation'  => 'required',
                'label'       => _('Status')
            ])
            ->add('role_id', 'choice', [
                'choices'     => \Role::getChoice(),
                'empty_value' => _('-'),
                'validation'  => 'required',
                'label'       => _('Role')
            ])
            ->addDefaultActions();
    }

    protected function getUpdateRules()
    {
        $key                           = \Input::get($this->model->getKeyName());
        static::$rules_update['email'] = 'required|email|unique:users,email,' . $key;

        return parent::getUpdateRules();
    }

    // ------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------

}