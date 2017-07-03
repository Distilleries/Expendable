<?php

class UserTest extends ExpendableTestCase {


    protected function addContent()
    {
        $faker = Faker\Factory::create();
        $role  = \Distilleries\Expendable\Models\Role::create([
            'libelle'            => $faker->text(),
            'initials'           => $faker->name,
            'overide_permission' => true,
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

    public function testUserRole()
    {
        list($role, $service, $permission, $user) = $this->addContent();

        $expected = \Distilleries\Expendable\Models\Role::find($role->id);
        $this->assertEquals($expected->toArray(), $user->role->toArray());
    }

    public function testGetFirstRedirect()
    {
        list($role, $service, $permission, $user) = $this->addContent();

        $left = config('expendable.menu.left');
        $this->assertEquals(action($left[0]['action']), $user->getFirstRedirect($left));
    }

    public function testGetFirstRedirectSubelement()
    {
        list($role, $service, $permission, $user) = $this->addContent();

        $left = [
            [
                'icon'    => 'user',
                'action'  => '\Distilleries\Expendable\Http\Controllers\Backend\UserController@getIndex',
                'libelle' => 'expendable::menu.user',
                'submenu' => [
                    [
                        'icon'    => 'th-list',
                        'libelle' => 'expendable::menu.list',
                        'action'  => '\Distilleries\Expendable\Http\Controllers\Backend\UserController@getIndex',
                    ],
                    [
                        'icon'    => 'pencil',
                        'libelle' => 'expendable::menu.add_state',
                        'action'  => '\Distilleries\Expendable\Http\Controllers\Backend\UserController@getEdit',
                    ],
                    [
                        'icon'    => 'barcode',
                        'libelle' => 'expendable::menu.my_profile',
                        'action'  => '\Distilleries\Expendable\Http\Controllers\Backend\UserController@getProfile',
                    ],
                ],
            ],
        ];

        $this->assertEquals(action($left[0]['submenu'][0]['action']), $user->getFirstRedirect($left));
    }

    public function testGetFirstRedirectSubelementEmpty()
    {
        list($role, $service, $permission, $user) = $this->addContent();

        $left = [
            [
                'icon'    => 'envelope',
                'action'  => '',
                'libelle' => 'expendable::menu.email',
                'submenu' => [
                    [
                        'icon'    => 'th-list',
                        'libelle' => 'expendable::menu.list_of',
                        'action'  => '',
                    ]
                ]
            ]
        ];

        $this->assertEquals('', $user->getFirstRedirect($left));
    }

    public function testHasAccess(){
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


        $this->assertFalse($user->hasAccess('test'));
    }
}