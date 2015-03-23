<?php namespace Distilleries\Expendable\Datatables;

use Distilleries\DatatableBuilder\EloquentDatatable;

abstract class BaseDatatable extends EloquentDatatable {

    // ------------------------------------------------------------------------------------------------
    public function addDefaultAction($template = 'expendable::admin.form.components.datatable.actions', $route = '')
    {
        parent::addDefaultAction($template, $route);
    }
} 