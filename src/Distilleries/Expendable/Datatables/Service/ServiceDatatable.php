<?php namespace Distilleries\Expendable\Datatables\Service;


use Distilleries\DatatableBuilder\EloquentDatatable;

class ServiceDatatable extends EloquentDatatable
{
    public function build()
    {
        $this
            ->add('id',null,_('Id'))
            ->add('action',null,_('Action'));

        $this->addDefaultAction();

    }
}
