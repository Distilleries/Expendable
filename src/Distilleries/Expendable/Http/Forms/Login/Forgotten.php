<?php namespace Distilleries\Expendable\Http\Forms\Login;

use Distilleries\FormBuilder\FormValidator;

class Forgotten extends FormValidator {

    public static $rules = [
        'email'    => 'required|email'
    ];

    public function buildForm()
    {
        $this->add('email', 'email',
            [
                'label' => trans('expendable::form.email'),
                'validation' => 'required,custom[email]',
                'attr' => [
                    'class' => 'placeholder-no-fix',
                ],

            ])
            ->add('send', 'submit',
            [
                'label' => trans('expendable::form.send'),
                'attr' => [
                    'class' =>'btn green-haze pull-right'
                ],
            ]);
    }
}