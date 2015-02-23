<?php namespace Distilleries\Expendable\Contracts;

interface CsvExporterContract {

    public function export($data, $filename);
}