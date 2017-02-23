<?php namespace Distilleries\Expendable\Config;

class MenuConfig {

    public static function menu($merge = [], $direction = 'end')
    {

        $first = [
            'left'  => [
                [
                    'icon'    => 'user',
                    'action'  => '\Distilleries\Expendable\Http\Controllers\Admin\UserController@getIndex',
                    'libelle' => 'expendable::menu.user',
                    'submenu' => [
                        [
                            'icon'    => 'th-list',
                            'libelle' => 'expendable::menu.list',
                            'action'  => '\Distilleries\Expendable\Http\Controllers\Admin\UserController@getIndex',
                        ],
                        [
                            'icon'    => 'pencil',
                            'libelle' => 'expendable::menu.add_state',
                            'action'  => '\Distilleries\Expendable\Http\Controllers\Admin\UserController@getEdit',
                        ],
                        [
                            'icon'    => 'barcode',
                            'libelle' => 'expendable::menu.my_profile',
                            'action'  => '\Distilleries\Expendable\Http\Controllers\Admin\UserController@getProfile',
                        ],
                    ],
                ],
                [
                    'icon'    => 'cog',
                    'action'  => '\Distilleries\Expendable\Http\Controllers\Admin\RoleController@getIndex',
                    'libelle' => 'expendable::menu.administration',
                    'submenu' => [
                        [
                            'icon'    => 'certificate',
                            'action'  => '\Distilleries\Expendable\Http\Controllers\Admin\RoleController@getIndex',
                            'libelle' => 'expendable::menu.role',
                            'submenu' => [
                                [
                                    'icon'    => 'th-list',
                                    'libelle' => 'expendable::menu.list',
                                    'action'  => '\Distilleries\Expendable\Http\Controllers\Admin\RoleController@getIndex',
                                ],
                                [
                                    'icon'    => 'pencil',
                                    'libelle' => 'expendable::menu.add_state',
                                    'action'  => '\Distilleries\Expendable\Http\Controllers\Admin\RoleController@getEdit',
                                ],
                            ],
                        ],
                        [
                            'icon'    => 'wrench',
                            'action'  => '\Distilleries\Expendable\Http\Controllers\Admin\PermissionController@getIndex',
                            'libelle' => 'expendable::menu.permission',
                            'submenu' => [
                                [
                                    'icon'    => 'th-list',
                                    'libelle' => 'expendable::menu.list',
                                    'action'  => '\Distilleries\Expendable\Http\Controllers\Admin\ServiceController@getIndex',
                                ],
                                [
                                    'icon'    => 'pencil',
                                    'libelle' => 'expendable::menu.add_state',
                                    'action'  => '\Distilleries\Expendable\Http\Controllers\Admin\ServiceController@getEdit',
                                ],
                                [
                                    'icon'    => 'refresh',
                                    'libelle' => 'expendable::menu.sync_service',
                                    'action'  => '\Distilleries\Expendable\Http\Controllers\Admin\ServiceController@getSynchronize',
                                ],
                                [
                                    'icon'    => 'ok-circle',
                                    'libelle' => 'expendable::menu.associate_permission',
                                    'action'  => '\Distilleries\Expendable\Http\Controllers\Admin\PermissionController@getIndex',
                                ],
                            ],
                        ],
                        [
                            'icon'    => 'flag',
                            'action'  => '\Distilleries\Expendable\Http\Controllers\Admin\LanguageController@getIndex',
                            'libelle' => 'expendable::menu.language',
                            'submenu' => [
                                [
                                    'icon'    => 'th-list',
                                    'libelle' => 'expendable::menu.list',
                                    'action'  => '\Distilleries\Expendable\Http\Controllers\Admin\LanguageController@getIndex',
                                ],
                                [
                                    'icon'    => 'pencil',
                                    'libelle' => 'expendable::menu.add_state',
                                    'action'  => '\Distilleries\Expendable\Http\Controllers\Admin\LanguageController@getEdit',
                                ],
                            ],
                        ],
                    ]
                ],
            ],

            'tasks' => [
                [
                    'icon'    => 'console',
                    'action'  => '\Distilleries\Expendable\Http\Controllers\Admin\ComponentController@getIndex',
                    'libelle' => 'expendable::menu.generate_component',

                ],
                [
                    'icon'    => 'retweet',
                    'action'  => '\Distilleries\Expendable\Http\Controllers\Admin\ServiceController@getSynchronize',
                    'libelle' => 'expendable::menu.sync_service',

                ],
            ]
        ];


        if ($direction == 'end')
        {
            $first['left']  = !empty($merge['left']) ? array_merge($first['left'], $merge['left']) : $first['left'];
            $first['tasks'] = !empty($merge['tasks']) ? array_merge($first['tasks'], $merge['tasks']) : $first['tasks'];
        } else
        {
            $first['left']  = !empty($merge['left']) ? array_merge($merge['left'], $first['left']) : $first['left'];
            $first['tasks'] = !empty($merge['tasks']) ? array_merge($merge['tasks'], $first['tasks']) : $first['tasks'];
        }


        return $first;
    }
}