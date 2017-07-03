<?php namespace Distilleries\Expendable\Http\Forms\Email;

use Distilleries\Expendable\Helpers\StaticLabel;
use Distilleries\FormBuilder\FormValidator;

class EmailForm extends FormValidator {

    public static $rules = [
        'libelle'   => 'required',
        'body_type' => 'required',
        'action'    => 'required',
        'status'    => 'required|integer'
    ];

    // ------------------------------------------------------------------------------------------------

    public function buildForm()
    {

        $this
            ->add($this->model->getKeyName(), 'hidden')
            ->add('libelle', 'text', [
                'validation' => 'required',
                'label'      => trans('expendable::form.subject')
            ])
            ->add('body_type', 'choice', [
                'choices'     => StaticLabel::bodyType(),
                'empty_value' => '-',
                'validation'  => 'required',
                'label'       => trans('expendable::form.body_type')
            ])
            ->add('action', 'choice', [
                'choices'     => StaticLabel::mailActions(),
                'empty_value' => '-',
                'validation'  => 'required',
                'label'       => trans('expendable::form.action')
            ])
            ->add('cc', 'tag', [
                'label' => trans('expendable::form.cc')
            ])
            ->add('bcc', 'tag', [
                'label' => trans('expendable::form.bcc')
            ])
            ->add('content', 'tinymce', [
                'validation' => 'required',
                'label'      => trans('expendable::form.content')
            ])
            ->add('status', 'choice', [
                'choices'     => StaticLabel::status(),
                'empty_value' => '-',
                'validation'  => 'required',
                'label'       => trans('expendable::form.status')
            ])
            ->addDefaultActions();
    }
}