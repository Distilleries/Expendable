<?php

use Distilleries\Expendable\Models\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder {

    public function run()
    {
        Role::create([
            'libelle'            => 'superadmin',
            'initials'           => '@sa',
            'overide_permission' => true,
        ]);

        Role::create([
            'libelle'  => 'admin',
            'initials' => '@a',
            'overide_permission' => false,
        ]);
    }
}