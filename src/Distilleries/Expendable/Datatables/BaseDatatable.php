<?php namespace Distilleries\Expendable\Datatables;

use Distilleries\DatatableBuilder\EloquentDatatable;
use Distilleries\Expendable\Models\Language;
use Distilleries\Expendable\Models\Translation;

abstract class BaseDatatable extends EloquentDatatable {


    // ------------------------------------------------------------------------------------------------
    public function addTranslationAction($template = 'expendable::admin.form.components.datatable.translations', $route = '')
    {
        $this->add('translation', function ($model) use ($template, $route) {

            $languages    = Language::withoutCurrentLanguage()->get();
            $translations = Translation::byElement($model)->lists('id_element','iso')->toArray();
            return view($template, array(
                'languages'    => $languages,
                'translations' => $translations,
                'data'         => $model->toArray(),
                'route'        => !empty($route) ? $route . '@' : $this->getControllerNameForAction() . '@'
            ))->render();
        });

    }

    // ------------------------------------------------------------------------------------------------
    public function addDefaultAction($template = 'expendable::admin.form.components.datatable.actions', $route = '')
    {
        parent::addDefaultAction($template, $route);
    }
} 