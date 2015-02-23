<?php namespace Distilleries\Expendable\Datatables\Service;

use Distilleries\Expendable\Datatables\BaseDatatable;

class ServiceDatatable extends BaseDatatable
{
    public function build()
    {
        $this
            ->add('id',null,_('Id'))
            ->add('action',null,_('Action'));

        $this->addDefaultAction();

    }
}