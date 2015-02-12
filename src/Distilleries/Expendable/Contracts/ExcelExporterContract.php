<?php
/**
 * Created by PhpStorm.
 * User: mfrancois
 * Date: 6/02/2015
 * Time: 4:40 PM
 */

namespace Distilleries\Expendable\Contracts;


interface ExcelExporterContract {

    public function export($data,$filename);
}