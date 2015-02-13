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
                ->add('source_path', 'text', [
                    'label'      => _('Path repository'),
                    'help'=>_('For exemple you have a folder Xyz in app/Xyz, just put Xyz.')
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
        $models = File::files(app_path() . DIRECTORY_SEPARATOR . 'models');

        $choices = [];
        foreach($models as $model){
            $choice = explode('/',$model);
            $model = preg_replace('/.php/i','',last($choice));
            $choices[$model] = $model;
        }
        return $choices;
    }
} 