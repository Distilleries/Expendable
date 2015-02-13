<?php
/**
 * Created by PhpStorm.
 * User: mfrancois
 * Date: 13/02/2015
 * Time: 1:10 PM
 */

namespace Distilleries\Expendable\Importer;

use \Excel;

use Distilleries\Expendable\Contracts\CsvImporterContract;

class CsvImporter implements CsvImporterContract {

    public function getArrayDataFromFile($file)
    {
        $data = Excel::load($file, 'UTF-8');

        return $data->toArray();
    }
}