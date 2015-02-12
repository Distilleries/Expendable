<?php
/**
 * Created by PhpStorm.
 * User: mfrancois
 * Date: 6/02/2015
 * Time: 4:37 PM
 */

namespace Distilleries\Expendable\Exporter;

use Distilleries\Expendable\Contracts\PdfExporterContract;

class PdfExporter implements PdfExporterContract {



    public function export($data,$filename='')
    {

        return \Excel::create($filename, function($excel) use($data) {

            $excel->sheet('export', function($sheet) use($data) {

                $sheet->fromArray($data);
                $sheet->freezeFirstRow();
                $sheet->setAutoFilter();
                $sheet->row(1, function($row) {
                    $row->setValignment('middle');
                    $row->setAlignment('center');
                    $row->setFontColor('#ffffff');
                    $row->setFont(array(
                        'size'       => '12',
                        'bold'       =>  true
                    ));
                    $row->setBackground('#000000');

                });

            });



        })->export('pdf')->download('pdf');
    }
}