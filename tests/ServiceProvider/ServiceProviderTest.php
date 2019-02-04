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
}

