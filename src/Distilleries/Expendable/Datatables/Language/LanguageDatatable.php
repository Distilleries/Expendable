<?php namespace Distilleries\Expendable\Datatables\Language;



use Distilleries\DatatableBuilder\EloquentDatatable;

class LanguageDatatable extends EloquentDatatable {

    public function build()
    {
        $this
            ->add('id', null, _('Id'))
            ->add('libelle', null, _('Libelle'))
            ->add('iso', null, _('Iso'));

        $this->addDefaultAction();

    }


    public function setClassRow($datatable)
    {
        $datatable->setRowClass(function ($row)
        {
            $class = (isset($row->status) and empty($row->status)) ? 'danger' : '';
            $class = (empty($class) and !empty($row->not_visible)) ? 'warning' : $class;

            return $class;
        });

        return $datatable;
    }
}
