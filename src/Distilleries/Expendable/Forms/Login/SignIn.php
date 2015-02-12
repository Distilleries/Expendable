<?php

namespace Distilleries\Expendable\Forms\Login;


use Distilleries\FormBuilder\FormValidator;

class SignIn extends FormValidator {

    public static $rules = [
        'email'    => 'required|email',
        'password' => 'required',
    ];

    // ------------------------------------------------------------------------------------------------


    public function buildForm()
    {
        $this->add('email', 'email',
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
                    'validation' => 'required',
                    'attr'       => [
                        'class' => 'placeholder-no-fix'
                    ],
                ])
            ->add('login', 'submit',
                [
                    'label' => _('Login'),
                    'attr'  => [
                        'class' => 'btn green-haze pull-right'
                    ],
                ]);
    }

    // ------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------

}