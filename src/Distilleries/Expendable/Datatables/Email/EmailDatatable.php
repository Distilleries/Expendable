<?php


namespace Distilleries\Expendable\Datatables\Email;


use Distilleries\DatatableBuilder\EloquentDatatable;
use Distilleries\Expendable\Helpers\StaticLabel;

class EmailDatatable extends EloquentDatatable {

    public function build()
    {
        $this->add('id');
        $this->add('libelle',null,_('Subject'));
        $this->add('body_type', function ($model)
        {
            return StaticLabel::bodyType($model->body_type);
        }, _('Type'));
        $this->add('action', function ($model)
        {
            return StaticLabel::mailActions($model->action);
        });
        $this->add('cc');
        $this->add('bcc');
        $this->addDefaultAction();
    }
} 