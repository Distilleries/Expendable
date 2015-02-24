<?php


namespace Distilleries\Expendable\Forms\Component;

use Distilleries\Expendable\Helpers\StaticLabel;
use \File;

class ComponentForm extends \Distilleries\FormBuilder\FormValidator {

    public function buildForm()
    {

            $this
                ->add('libelle', 'text', [
                    'validation' => 'required',
                    'label'      => _('Name'),
                    'help'=>_('We automatically add Controller in sufix')
                ])
                ->add('state', 'choice', [
                    'choices'     => StaticLabel::states(),
                    'empty_value' => _('-'),
                    'label'       => _('State'),
                    'expanded' => true,
                    'multiple' => true
                ])
                ->add('models', 'choice', [
                    'choices'     => $this->getChoiceModels(),
                    'empty_value' => _('-'),
                    'label'       => _('Model')
                ])
                ->add('colon_datatable', 'tag', [
                    'label' => _('Columns'),
                    'help'=>_('name: id, libelle...')
                ])
                ->add('fields_form', 'tag', [
                    'label' => _('Fields'),
                    'help'=>_('name:type, text,textarea, tinymce, choice(checkbox, radio, select)...')
                ])
                ->addDefaultActions();
    }

    protected function getChoiceModels()
    {
        $allModels = [
            [
                'path'=>app_path().DIRECTORY_SEPARATOR ,
                'namespace'=>'{{app}}',
            ],
            [
                'path'=>__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Models'.DIRECTORY_SEPARATOR ,
                'namespace'=>'Distilleries\\Expendable\\Models\\',
            ],
        ];

        $choices = [];
        foreach($allModels as $config){
            $models = File::files($config['path']);
            foreach($models as $model){
                $choice = explode('/',$model);
                $model = preg_replace('/.php/i','',last($choice));
                $choices[$config['namespace'].$model] = $model;
            }
        }

        return $choices;
    }
} 