<?php namespace Distilleries\Expendable\Contracts;

interface PdfExporterContract {

    public function export($data,$filename);
}