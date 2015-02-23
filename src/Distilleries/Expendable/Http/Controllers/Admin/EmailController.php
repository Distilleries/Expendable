<?php namespace Distilleries\Expendable\Http\Controllers\Admin;

use Distilleries\Expendable\Contracts\LayoutManagerContract;
use Distilleries\Expendable\Datatables\Email\EmailDatatable;
use Distilleries\Expendable\Forms\Email\EmailForm;
use Distilleries\Expendable\Http\Controllers\Admin\Base\BaseComponent;
use Distilleries\Expendable\Models\Email;

class EmailController extends BaseComponent {

    public function __construct(EmailDatatable $datatable, EmailForm $form, Email $model, LayoutManagerContract $layoutManager)
    {
        parent::__construct($model, $layoutManager);

        $this->datatable = $datatable;
        $this->form      = $form;
    }
}