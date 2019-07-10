<?php namespace Distilleries\Expendable\Http\Forms\Component;

use Distilleries\Expendable\Helpers\StaticLabel;
use \File;

class ComponentForm extends \Distilleries\FormBuilder\FormValidator
{

    public static $rules = [
        'libelle' => 'required'
    ];
    public static $rules_update = null;

    public function buildForm()
    {

        $this
            ->add('libelle', 'text', [
                'validation' => 'required',
                'label' => trans('expendable::form.name'),
                'help' => trans('expendable::form.auto_sufix')
            ])
            ->add('state', 'choice', [
                'choices' => StaticLabel::states(),
                'empty_value' => '-',
                'label' => trans('expendable::form.state'),
                'expanded' => true,
                'multiple' => true
            ])
            ->add('models', 'choice', [
                'choices' => $this->getChoiceModels(),
                'empty_value' => '-',
                'label' => trans('expendable::form.model')
            ])
            ->add('colon_datatable', 'tag', [
                'label' => trans('expendable::form.columns'),
                'help' => trans('expendable::form.help_colon_datatable')
            ])
            ->add('fields_form', 'tag', [
                'label' => trans('expendable::form.fields'),
                'help' => trans('expendable::form.help_fields_form')
            ])
            ->addDefaultActions();
    }

    protected function getChoiceModels()
    {
        $allModels = [
            [
                'path' => app_path().DIRECTORY_SEPARATOR,
                'namespace' => '{{app}}',
            ],
            [
                'path' => app_path().DIRECTORY_SEPARATOR.'Models'.DIRECTORY_SEPARATOR,
                'namespace' => '{{app}}Models\\',
            ],
            [
                'path' => __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Models'.DIRECTORY_SEPARATOR,
                'namespace' => 'Distilleries\\Expendable\\Models\\',
            ],
        ];

        $choices = [];
        foreach ($allModels as $config) {
            if (app('files')->isDirectory($config['path'])) {
                $models = app('files')->files($config['path']);
                foreach ($models as $model) {
                    $choice = explode('/', $model);
                    $model = preg_replace('/.php/i', '', last($choice));
                    $choices[$config['namespace'].$model] = $model;
                }
            }

        }

        return $choices;
    }
}