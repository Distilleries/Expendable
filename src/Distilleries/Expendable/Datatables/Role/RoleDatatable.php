<?php namespace Distilleries\Expendable\Datatables\Role;


use Distilleries\DatatableBuilder\EloquentDatatable;

class RoleDatatable extends EloquentDatatable
{
    public function build()
    {
        $this
            ->add('id',null,_('Id'))
            ->add('libelle',null,_('Libelle'))
            ->add('initials',null,_('Initials'));

        $this->addDefaultAction();

    }
}
