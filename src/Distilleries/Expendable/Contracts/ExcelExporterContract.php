<?php namespace Distilleries\Expendable\Contracts;

interface ExcelExporterContract {

    public function export($data, $filename);
}