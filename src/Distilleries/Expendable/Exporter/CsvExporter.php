<?php namespace Distilleries\Expendable\Exporter;

use Distilleries\Expendable\Contracts\CsvExporterContract;

class CsvExporter implements CsvExporterContract {



    public function export($data,$filename='')
    {
        return  \CSV::fromArray($data)->render();
    }
}