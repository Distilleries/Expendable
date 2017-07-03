<?php namespace Distilleries\Expendable\Http\Datatables\Service;

use Distilleries\Expendable\Http\Datatables\BaseDatatable;

class ServiceDatatable extends BaseDatatable {

    public function build()
    {
        $this
            ->add('id', null, trans('expendable::datatable.id'))
            ->add('action', null, trans('expendable::datatable.action'));

        $this->addDefaultAction();

    }
}