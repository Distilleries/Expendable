<?php namespace Distilleries\Expendable\Http\Datatables\Email;

use Distilleries\Expendable\Http\Datatables\BaseDatatable;
use Distilleries\Expendable\Helpers\StaticLabel;

class EmailDatatable extends BaseDatatable {

    public function build()
    {
        $this->add('id');
        $this->add('libelle', null, trans('expendable::datatable.subject'));
        $this->add('body_type', function($model)
        {
            return StaticLabel::bodyType($model->body_type);
        },trans('expendable::datatable.type'));
        $this->add('action', function($model)
        {
            return StaticLabel::mailActions($model->action);
        });
        $this->add('cc');
        $this->add('bcc');
        $this->addTranslationAction();
        $this->addDefaultAction();
    }
}