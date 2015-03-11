<?php

class LanguageTest extends ExpendableTestCase {


    protected function addContent()
    {

        $faker = Faker\Factory::create();
        $data  = [
            'libelle'     => $faker->realText(20),
            'iso'         => $faker->iso8601,
            'not_visible' => false,
            'is_default'  => false,
            'status'      => true

        ];


        $result = \Distilleries\Expendable\Models\Language::create($data);
        $result = \Distilleries\Expendable\Models\Language::find($result->id);

        return [$data, $result];
    }

    public function testLanguage()
    {
        list($data, $model) = $this->addContent();

        $language =  \Distilleries\Expendable\Models\Language::find($model->id);

        $this->assertEquals($model, $language);

    }
}