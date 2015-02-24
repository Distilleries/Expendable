<?php

namespace Distilleries\Expendable\Forms\Login;


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
                    'label'      => _('Email'),
                    'validation' => 'required,custom[email]',
                    'attr'       => [
                        'class' => 'placeholder-no-fix',
                    ],

                ])
            ->add('password', 'password',
                [
                    'label'      => _('Password'),
                    'validation' => 'required'
                ])
            ->add('password_confirmation', 'password',
                [
                    'label'      => _('Repeat Password'),
                    'validation' => 'required,equals[password]'
                ])
            ->add('send', 'submit',
                [
                    'label' => _('Send'),
                    'attr'  => [
                        'class' => 'btn green-haze pull-right'
                    ],
                ]);
    }
}