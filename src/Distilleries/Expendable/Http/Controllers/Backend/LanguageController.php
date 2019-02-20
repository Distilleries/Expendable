<?php namespace Distilleries\Expendable\Http\Controllers\Backend;

use Distilleries\Expendable\Contracts\LayoutManagerContract;
use Distilleries\Expendable\Http\Datatables\Language\LanguageDatatable;
use Distilleries\Expendable\Http\Forms\Language\LanguageForm;
use Distilleries\Expendable\Http\Controllers\Backend\Base\BaseComponent;
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
        session()->put('language', $locale);
        app()->setLocale($locale);
        return redirect()->back();
    }
}