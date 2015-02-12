<?php


namespace Distilleries\Expendable\Controllers\Admin;


use Distilleries\Expendable\Contracts\StateDisplayerContract;
use Distilleries\Expendable\Controllers\AdminBaseComponent;
use Distilleries\Expendable\Datatables\Language\LanguageDatatable;
use Distilleries\Expendable\Forms\Language\LanguageForm;

class LanguageController  extends AdminBaseComponent {

    public function __construct(\Language $model, StateDisplayerContract $stateProvider, LanguageDatatable $datatable, LanguageForm $form)
    {
        parent::__construct($model, $stateProvider);
        $this->datatable = $datatable;
        $this->form      = $form;
    }



    // ------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------


}