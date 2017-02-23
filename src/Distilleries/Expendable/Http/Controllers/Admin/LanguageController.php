<?php namespace Distilleries\Expendable\Http\Controllers\Admin;

use Distilleries\Expendable\Contracts\LayoutManagerContract;
use Distilleries\Expendable\Datatables\Language\LanguageDatatable;
use Distilleries\Expendable\Forms\Language\LanguageForm;
use Distilleries\Expendable\Http\Controllers\Admin\Base\BaseComponent;
use Distilleries\Expendable\Models\Language;

class LanguageController extends BaseComponent {

    public function __construct(LanguageDatatable $datatable, LanguageForm $form, Language $model, LayoutManagerContract $layoutManager)
    {
        parent::__construct($model, $layoutManager);
        $this->datatable = $datatable;
        $this->form      = $form;
    }


    public function getChangeLang($locale = null)
    {
        session()->put('language',$locale);
        app()->setLocale($locale);
        return redirect()->back();
    }
}