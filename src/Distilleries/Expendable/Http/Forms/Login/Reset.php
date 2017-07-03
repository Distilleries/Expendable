<?php namespace Distilleries\Expendable\Http\Forms\Login;

use Distilleries\FormBuilder\FormValidator;

class Reset extends FormValidator {

    public static $rules = [
        'email'    => 'required|email',
        'password' => 'required|min:8',
        'account'  => 'required',
        'token'    => 'required',
    ];

    public function buildForm()
    {
        $this
            ->add('token', 'hidden', [
                'default_value' => $this->getData('token')
            ])
            ->add('email', 'email',
                [
                    'label'      => trans('expendable::form.email'),
                    'validation' => 'required,custom[email]',
                    'attr'       => [
                        'class' => 'placeholder-no-fix',
                    ],

                ])
            ->add('password', 'password',
                [
                    'label'      => trans('expendable::form.password'),
                    'validation' => 'required'
                ])
            ->add('password_confirmation', 'password',
                [
                    'label'      => trans('expendable::form.repeat_password'),
                    'validation' => 'required,equals[password]'
                ])
            ->add('send', 'submit',
                [
                    'label' => trans('expendable::form.send'),
                    'attr'  => [
                        'class' => 'btn green-haze pull-right'
                    ],
                ]);
    }
}