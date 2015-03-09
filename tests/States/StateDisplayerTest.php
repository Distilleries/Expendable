<?php

class StateDisplayerTest extends ExpendableTestCase {

    public function testStateDisplayerContractRegister()
    {
        $this->initService();
        $object = $this->app->make('Distilleries\Expendable\Contracts\StateDisplayerContract');
        $this->assertInstanceOf('Distilleries\Expendable\Contracts\StateDisplayerContract', $object);
    }

}

