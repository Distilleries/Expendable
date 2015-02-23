<?php namespace Distilleries\Expendable\Contracts;

use Illuminate\Http\Request;

interface ImportStateContract {

    public function getImport();

    public function postImport(Request $request);
}