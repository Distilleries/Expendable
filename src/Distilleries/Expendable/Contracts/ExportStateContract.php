<?php namespace Distilleries\Expendable\Contracts;

use Illuminate\Http\Request;

interface ExportStateContract {

    public function getExport();

    public function postExport(Request $request);
}