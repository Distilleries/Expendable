<?php

class StaticLabelTest extends ExpendableTestCase {

    public function testYesNoArray()
    {
        $result = \Distilleries\Expendable\Helpers\StaticLabel::yesNo();

        $this->assertTrue(is_array($result));
        $this->assertArrayHasKey(\Distilleries\Expendable\Helpers\StaticLabel::STATUS_OFFLINE, $result);
        $this->assertArrayHasKey(\Distilleries\Expendable\Helpers\StaticLabel::STATUS_ONLINE, $result);
    }

    public function testYes()
    {
        $result = \Distilleries\Expendable\Helpers\StaticLabel::yesNo(\Distilleries\Expendable\Helpers\StaticLabel::STATUS_ONLINE);

        $this->assertTrue(is_string($result));
        $this->assertEquals($this->app['translator']->trans('expendable::label.yes'), $result);
    }

    public function testNa()
    {
        $result = \Distilleries\Expendable\Helpers\StaticLabel::yesNo(- 1);

        $this->assertTrue(is_string($result));
        $this->assertEquals($this->app['translator']->trans('expendable::label.na'), $result);
    }


    public function testStatusArray()
    {
        $result = \Distilleries\Expendable\Helpers\StaticLabel::status();

        $this->assertTrue(is_array($result));
        $this->assertArrayHasKey(\Distilleries\Expendable\Helpers\StaticLabel::STATUS_OFFLINE, $result);
        $this->assertArrayHasKey(\Distilleries\Expendable\Helpers\StaticLabel::STATUS_ONLINE, $result);
    }

    public function testTypeExportArray()
    {
        $result = \Distilleries\Expendable\Helpers\StaticLabel::typeExport();

        $this->assertTrue(is_array($result));
        $this->assertArrayHasKey('xls', $result);
        $this->assertArrayHasKey('csv', $result);
    }

    public function testBodyTypeArray()
    {
        $result = \Distilleries\Expendable\Helpers\StaticLabel::bodyType();

        $this->assertTrue(is_array($result));
        $this->assertArrayHasKey(\Distilleries\Expendable\Helpers\StaticLabel::BODY_TYPE_HTML, $result);
        $this->assertArrayHasKey(\Distilleries\Expendable\Helpers\StaticLabel::BODY_TYPE_TEXT, $result);
    }

    public function testMailActionsArray()
    {
        $config = $this->app['config']->get('expendable.mail.actions');
        $result = \Distilleries\Expendable\Helpers\StaticLabel::mailActions();

        $this->assertTrue(is_array($result));

        foreach ($config as $value)
        {
            $this->assertArrayHasKey($value, $result);
        }
    }

    public function testStatesArray()
    {
        $config = $this->app['config']->get('expendable.state');
        $result = \Distilleries\Expendable\Helpers\StaticLabel::states();

        $this->assertTrue(is_array($result));

        foreach ($config as $key=>$value)
        {
            $this->assertArrayHasKey($key, $result);
        }
    }

}