<?php

class ExpendableProviderTest extends ExpendableTestCase {

    public function testStateDisplayerContractProvided()
    {
        $this->initService();
        $this->assertTrue(in_array('Distilleries\Expendable\Contracts\StateDisplayerContract', $this->facades));
    }

    public function testLayoutManagerContractProvided()
    {
        $this->initService();
        $this->assertTrue(in_array('Distilleries\Expendable\Contracts\LayoutManagerContract', $this->facades));
    }

    public function testMailModelContractProvided()
    {
        $this->initService();
        $this->assertTrue(in_array('Distilleries\MailerSaver\Contracts\MailModelContract', $this->facades));
    }

    public function testCsvImporterContractProvided()
    {
        $this->initService();
        $this->assertTrue(in_array('CsvImporterContract', $this->facades));
    }

    public function testXlsImporterContractProvided()
    {
        $this->initService();
        $this->assertTrue(in_array('XlsImporterContract', $this->facades));
    }

    public function testXlsxImporterContractProvided()
    {
        $this->initService();
        $this->assertTrue(in_array('XlsxImporterContract', $this->facades));
    }

    public function testCsvExporterContractProvided()
    {
        $this->initService();
        $this->assertTrue(in_array('Distilleries\Expendable\Contracts\CsvExporterContract', $this->facades));
    }

    public function testExcelExporterContractProvided()
    {
        $this->initService();
        $this->assertTrue(in_array('Distilleries\Expendable\Contracts\ExcelExporterContract', $this->facades));
    }

    public function testPdfExporterContractProvided()
    {
        $this->initService();
        $this->assertTrue(in_array('Distilleries\Expendable\Contracts\PdfExporterContract', $this->facades));
    }
}

