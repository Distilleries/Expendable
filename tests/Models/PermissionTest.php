<?php

class PermissionTest extends ExpendableTestCase {


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

        return [$role, $service, $permission];
    }

    public function testPermissionRole()
    {
        list($role, $service, $permission) = $this->addContent();

        $expected = \Distilleries\Expendable\Models\Role::find($role->id);
        $this->assertEquals($expected->toArray(), $permission->role->toArray());
    }

    public function testPermissionService()
    {
        list($role, $service, $permission) = $this->addContent();

        $expected = \Distilleries\Expendable\Models\Service::find($service->id);
        $this->assertEquals($expected->toArray(), $permission->service->toArray());
    }

    public function testPermissionGetArea()
    {
        list($role, $service, $permission) = $this->addContent();

        $result = $permission->getArea();
        $equal = false;
        foreach($result as $role_result){

            if($role_result['libelle'] == $role->libelle && $role->id == $role_result['id']){
                $equal = true;
            }

        }

        $this->assertTrue($equal);
    }

    public function testPermissionGetAreaSelected()
    {
        list($role, $service, $permission) = $this->addContent();

        $result = $permission->getAreaSelected();
        $this->assertArrayHasKey($role->id,$result);
        $this->assertTrue(in_array($service->id,$result[$role->id]));
    }


}