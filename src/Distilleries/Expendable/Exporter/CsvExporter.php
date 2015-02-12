<?php
/**
 * Created by PhpStorm.
 * User: mfrancois
 * Date: 6/02/2015
 * Time: 4:37 PM
 */

namespace Distilleries\Expendable\Exporter;


use Distilleries\Expendable\Contracts\CsvExporterContract;

class CsvExporter implements CsvExporterContract {



    public function export($data,$filename='')
    {
        return  \CSV::fromArray($data)->render();
    }
}