<?php namespace Distilleries\Expendable\Http\Datatables\Language;

use Distilleries\Expendable\Http\Datatables\BaseDatatable;

class LanguageDatatable extends BaseDatatable {

    public function build()
    {
        $this
            ->add('id', null, trans('expendable::datatable.id'))
            ->add('libelle', null, trans('expendable::datatable.libelle'))
            ->add('iso', null, trans('expendable::datatable.iso'));

        $this->addDefaultAction();

    }


    public function setClassRow($datatable)
    {
        $datatable->setRowClass(function($row)
        {
            $class = (isset($row->status) && empty($row->status)) ? 'danger' : '';
            $class = (empty($class) && !empty($row->not_visible)) ? 'warning' : $class;

            return $class;
        });

        return $datatable;
    }
}