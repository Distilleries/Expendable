<?php

use Faker\Factory as Faker;
use Distilleries\Expendable\Models\Language;
use Illuminate\Database\Seeder;

class LanguagesTableSeeder extends Seeder {

    public function run()
    {
        Language::create([
            'libelle'     => 'English',
            'iso'         => 'en',
            'status'      => true,
            'not_visible' => false,
            'is_default'  => true,
        ]);

        Language::create([
            'libelle'     => 'French',
            'iso'         => 'fr',
            'status'      => true,
            'not_visible' => true,
            'is_default'  => true,
        ]);


    }
}