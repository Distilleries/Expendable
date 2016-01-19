<?php

class StatusTraintTest extends ExpendableTestCase {


    protected function addContent()
    {

        $faker = Faker\Factory::create();

        \DB::table('languages')->truncate();

        \Distilleries\Expendable\Models\Language::create([
            'libelle'     => $faker->realText(20),
            'iso'         => $faker->iso8601,
            'not_visible' => false,
            'is_default'  => false,
            'status'      => true

        ]);
        \Distilleries\Expendable\Models\Language::create([
            'libelle'     => $faker->realText(20),
            'iso'         => $faker->iso8601,
            'not_visible' => false,
            'is_default'  => false,
            'status'      => false

        ]);

    }

    public function testLanguageOnlyOnline()
    {

        $this->addContent();
        $result = \Distilleries\Expendable\Models\Language::all();

        foreach ($result as $lang)
        {
            $this->assertEquals(1,$lang->status);
        }


    }

    public function testLanguageOnlyOffline()
    {
        $this->addContent();
        $result = \Distilleries\Expendable\Models\Language::onlyOffline()->get();

        foreach ($result as $lang)
        {
            $this->assertEquals(0,$lang->status);
        }
    }



    public function testLanguageWithOffline()
    {
        $this->addContent();
        $result = \Distilleries\Expendable\Models\Language::where('is_default',0)->withOffline()->get();

        $count = [];
        foreach ($result as $lang)
        {
            $count[$lang->status] = true;
        }
        $this->assertTrue(array_key_exists(0,$count));
        $this->assertTrue(array_key_exists(1,$count));
    }

    public function testLanguageOnlyAndOffline()
    {
        $this->addContent();
        $result = \Distilleries\Expendable\Models\Language::offlineAndOnline()->get();

        $count = [];
        foreach ($result as $lang)
        {
            $count[$lang->status] = true;
        }

        $this->assertTrue(array_key_exists(0,$count));
        $this->assertTrue(array_key_exists(1,$count));
    }


    public function testLanguageOnlyAndOfflineNoStatic()
    {
        $this->addContent();
        $model = new \Distilleries\Expendable\Models\Language;
        $result = $model->offlineAndOnline()->get();

        $count = [];
        foreach ($result as $lang)
        {
            $count[$lang->status] = true;
        }

        $this->assertTrue(array_key_exists(0,$count));
        $this->assertTrue(array_key_exists(1,$count));
    }


}