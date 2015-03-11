<?php

class ServiceTest extends ExpendableTestCase {


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


    public function testServicePermissions()
    {
        list($role, $service, $permission) = $this->addContent();

        $result = false;
        foreach ($service->permissions as $perms)
        {
            if ($perms->id == $permission->id)
            {
                $result = true;
            }
        }

        $this->assertTrue($result);
    }

    public function testServiceGetByAction()
    {
        list($role, $service, $permission) = $this->addContent();
        $newService = new \Distilleries\Expendable\Models\Service;
        $action = $newService->getByAction($service->action)->last();
        $this->assertEquals($service->id, $action->id);
    }


}