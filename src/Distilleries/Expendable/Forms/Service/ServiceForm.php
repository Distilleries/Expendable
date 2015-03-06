<?php namespace Distilleries\Expendable\Forms\Service;

use Distilleries\FormBuilder\FormValidator;

class ServiceForm extends FormValidator {

    public static $rules = [
        'action' => 'required|unique:services'
    ];

    public function buildForm()
    {
        $this
            ->add('id', 'hidden')
            ->add('action', 'text');

        $this->addDefaultActions();
    }
}