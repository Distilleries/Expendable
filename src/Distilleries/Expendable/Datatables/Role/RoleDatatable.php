<?php namespace Distilleries\Expendable\Datatables\Role;

use Distilleries\Expendable\Datatables\BaseDatatable;

class RoleDatatable extends BaseDatatable
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