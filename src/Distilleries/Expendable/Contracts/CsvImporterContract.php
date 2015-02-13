<?php
/**
 * Created by PhpStorm.
 * User: mfrancois
 * Date: 6/02/2015
 * Time: 4:40 PM
 */

namespace Distilleries\Expendable\Contracts;


interface CsvImporterContract {

    public function getArrayDataFromFile($file);
}