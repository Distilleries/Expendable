<?php

class RoleTest extends ExpendableTestCase {


    protected function addContent()
    {
        $faker = Faker\Factory::create();
        $role  = \Distilleries\Expendable\Models\Role::create([
            'libelle'            => $faker->text(),
            'initials'           => $faker->name,
            'overide_permission' => false,
        ]);

        $service = \Distilleries\Expendable\Models\Service::create([
            'action' => $faker->name().'@'.$faker->name(),
        ]);


        $permission = \Distilleries\Expendable\Models\Permission::create([
            'role_id'    => $role->id,
            'service_id' => $service->id,
        ]);

        $user = \Distilleries\Expendable\Models\User::create([
            'email'    => $faker->email,
            'password' => \Hash::make('test'),
            'status'   => true,
            'role_id'  => $role->id,
        ]);

        return [$role, $service, $permission, $user];
    }

    public function testRoleUser()
    {
        list($role, $service, $permission, $user) = $this->addContent();

        $this->assertEquals($user->id, $role->user->id);
    }

    public function testRolePermissions()
    {
        list($role, $service, $permission, $user) = $this->addContent();

        $result = false;
        foreach($role->permissions as $perms){
            if($perms->id == $permission->id){
                $result = true;
            }
        }

        $this->assertTrue($result);
    }


}