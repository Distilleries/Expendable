<?php namespace Distilleries\Expendable\Http\Forms\Login;

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
                'label'      => trans('expendable::form.email'),
                'validation' => 'required,custom[email]',
                'attr'       => [
                    'class' => 'placeholder-no-fix',
                ],

            ])
            ->add('password', 'password',
                [
                    'label'      => trans('expendable::form.password'),
                    'validation' => 'required',
                    'attr'       => [
                        'class' => 'placeholder-no-fix'
                    ],
                ])
            ->add('login', 'submit',
                [
                    'label' => trans('expendable::form.login'),
                    'attr'  => [
                        'class' => 'btn green-haze pull-right'
                    ],
                ]);
    }
}