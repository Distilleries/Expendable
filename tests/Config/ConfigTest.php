<?php

class ConfigTest extends ExpendableTestCase {


    public function testMergingBegening()
    {
        $fistMenu = \Distilleries\Expendable\Config\MenuConfig::menu([], 'beginning');

        $totalTask = count($fistMenu['tasks']);
        $totalLeft = count($fistMenu['left']);

        $left = [
            'icon'    => 'send',
            'action'  => 'Backend\ContactController@getIndex',
            'libelle' => 'Contact',
            'submenu' => [
                [
                    'icon'    => 'th-list',
                    'libelle' => 'List of Contact',
                    'action'  => 'Backend\ContactController@getIndex',
                ],
                [
                    'icon'    => 'pencil',
                    'libelle' => 'Add Contact',
                    'action'  => 'Backend\ContactController@getEdit',
                ]
            ]
        ];

        $task = [
            [
                'icon'    => 'globe',
                'action'  => 'Backend\CountryController@getIndex',
                'libelle' => 'Country'
            ]
        ];

        $menu = \Distilleries\Expendable\Config\MenuConfig::menu([
            'left' => [
                $left
            ],
            'tasks' => [
                $task
            ],
        ], 'beginning');

        $this->assertEquals($totalTask + 1, count($menu['tasks']));
        $this->assertEquals($totalLeft + 1, count($menu['left']));
        $this->assertEquals($task, $menu['tasks'][0]);
        $this->assertEquals($left, $menu['left'][0]);
    }



    public function testMergingEnd()
    {
        $fistMenu = \Distilleries\Expendable\Config\MenuConfig::menu([], 'end');

        $totalTask = count($fistMenu['tasks']);
        $totalLeft = count($fistMenu['left']);

        $left = [
            'icon'    => 'send',
            'action'  => 'Backend\ContactController@getIndex',
            'libelle' => 'Contact',
            'submenu' => [
                [
                    'icon'    => 'th-list',
                    'libelle' => 'List of Contact',
                    'action'  => 'Backend\ContactController@getIndex',
                ],
                [
                    'icon'    => 'pencil',
                    'libelle' => 'Add Contact',
                    'action'  => 'Backend\ContactController@getEdit',
                ]
            ]
        ];

        $task = [
            [
                'icon'    => 'globe',
                'action'  => 'Backend\CountryController@getIndex',
                'libelle' => 'Country'
            ]
        ];

        $menu = \Distilleries\Expendable\Config\MenuConfig::menu([
            'left' => [
                $left
            ],
            'tasks' => [
                $task
            ],
        ], 'end');

        $this->assertEquals($totalTask + 1, count($menu['tasks']));
        $this->assertEquals($totalLeft + 1, count($menu['left']));
        $this->assertEquals($task, end($menu['tasks']));
        $this->assertEquals($left, end($menu['left']));
    }
}

