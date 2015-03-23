<?php namespace Distilleries\Expendable\Exporter;

use Distilleries\Expendable\Contracts\CsvExporterContract;

class CsvExporter implements CsvExporterContract {



    public function export($data, $filename = '')
    {
        $excel = \Excel::create($filename, function($excel) use($data) {
            $excel->sheet('export', function($sheet) use($data) {
                $sheet->fromArray($data);
            });
        });

        if (app()->environment('testing'))
        {
            $excel->store('csv');
        }

        return $excel->export('csv')->download('xls');
    }
}