<?php namespace Distilleries\Expendable\Contracts;

interface CsvImporterContract {

    public function getArrayDataFromFile($file);
}