<?php namespace Distilleries\Expendable\Forms\Email;

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
                'label'      => _('Subject')
            ])
            ->add('body_type', 'choice', [
                'choices'    => StaticLabel::bodyType(),
                'empty_value' => _('-'),
                'validation' => 'required',
                'label'      => _('Body Type')
            ])
            ->add('action', 'choice', [
                'choices'     => StaticLabel::mailActions(),
                'empty_value' => _('-'),
                'validation'  => 'required',
                'label'       => _('Action')
            ])
            ->add('cc', 'tag', [
                'label'       => _('CC')
            ])
            ->add('bcc', 'tag', [
                'label'       => _('BCC')
            ])
            ->add('content', 'tinymce', [
                'validation' => 'required',
                'label'      => _('Content')
            ])

            ->add('status', 'choice', [
                'choices'     => StaticLabel::status(),
                'empty_value' => _('-'),
                'validation'  => 'required',
                'label'       => _('Status')
            ])
            ->addDefaultActions();
    }

    // ------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------

}