<?php namespace Distilleries\Expendable\Datatables\Service;

use Distilleries\Expendable\Datatables\BaseDatatable;

class ServiceDatatable extends BaseDatatable {

    public function build()
    {
        $this
            ->add('id', null, trans('expendable::datatable.id'))
            ->add('action', null, trans('expendable::datatable.action'));

        $this->addDefaultAction();

    }
}