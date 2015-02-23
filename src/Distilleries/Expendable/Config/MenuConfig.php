<?php


namespace Distilleries\Expendable\Config;


class MenuConfig {

    public static function menu($merge = [], $direction = 'end')
    {

        $first = [
            'left'  => [
                [
                    'icon'    => 'envelope',
                    'action'  => '\Distilleries\Expendable\Http\Controllers\Admin\EmailController@getIndex',
                    'libelle' => _('Email'),
                    'submenu' => [
                        [
                            'icon'    => 'th-list',
                            'libelle' => _('List of Email'),
                            'action'  => '\Distilleries\Expendable\Http\Controllers\Admin\EmailController@getIndex',
                        ],
                        [
                            'icon'    => 'pencil',
                            'libelle' => _('Add Email'),
                            'action'  => '\Distilleries\Expendable\Http\Controllers\Admin\EmailController@getEdit',
                        ]
                    ]
                ],
                [
                    'icon'    => 'user',
                    'action'  => '\Distilleries\Expendable\Http\Controllers\Admin\UserController@getIndex',
                    'libelle' => _('User'),
                    'submenu' => [
                        [
                            'icon'    => 'th-list',
                            'libelle' => _('List of user'),
                            'action'  => '\Distilleries\Expendable\Http\Controllers\Admin\UserController@getIndex',
                        ],
                        [
                            'icon'    => 'pencil',
                            'libelle' => _('Add User'),
                            'action'  => '\Distilleries\Expendable\Http\Controllers\Admin\UserController@getEdit',
                        ],
                        [
                            'icon'    => 'user',
                            'libelle' => _('My Profile'),
                            'action'  => '\Distilleries\Expendable\Http\Controllers\Admin\UserController@getProfile',
                        ]

                    ]
                ],
                [
                    'icon'    => 'paperclip',
                    'action'  => '\Distilleries\Expendable\Http\Controllers\Admin\RoleController@getIndex',
                    'libelle' => _('Role'),
                    'submenu' => [
                        [
                            'icon'    => 'th-list',
                            'libelle' => _('List of role'),
                            'action'  => '\Distilleries\Expendable\Http\Controllers\Admin\RoleController@getIndex',
                        ],
                        [
                            'icon'    => 'pencil',
                            'libelle' => _('Add Role'),
                            'action'  => '\Distilleries\Expendable\Http\Controllers\Admin\RoleController@getEdit',
                        ]

                    ]
                ],
                [
                    'icon'    => 'tags',
                    'action'  => '\Distilleries\Expendable\Http\Controllers\Admin\PermissionController@getIndex',
                    'libelle' => _('Permission'),
                    'submenu' => [
                        [
                            'icon'    => 'pencil',
                            'libelle' => _('Associate Permission'),
                            'action'  => '\Distilleries\Expendable\Http\Controllers\Admin\PermissionController@getIndex',
                        ],
                        [
                            'icon'    => 'th-list',
                            'libelle' => _('List of service'),
                            'action'  => '\Distilleries\Expendable\Http\Controllers\Admin\ServiceController@getIndex',
                        ],
                        [
                            'icon'    => 'pencil',
                            'libelle' => _('Add Service'),
                            'action'  => '\Distilleries\Expendable\Http\Controllers\Admin\ServiceController@getEdit',
                        ],
                        [
                            'icon'    => 'retweet',
                            'libelle' => _('Synchronize all services'),
                            'action'  => '\Distilleries\Expendable\Http\Controllers\Admin\ServiceController@getSynchronize',
                        ]
                    ]
                ],
                [
                    'icon'    => 'flag',
                    'action'  => '\Distilleries\Expendable\Http\Controllers\Admin\LanguageController@getIndex',
                    'libelle' => _('Language'),
                    'submenu' => [
                        [
                            'icon'    => 'th-list',
                            'libelle' => _('List of language'),
                            'action'  => '\Distilleries\Expendable\Http\Controllers\Admin\LanguageController@getIndex',
                        ],
                        [
                            'icon'    => 'pencil',
                            'libelle' => _('Add Language'),
                            'action'  => '\Distilleries\Expendable\Http\Controllers\Admin\LanguageController@getEdit',
                        ]

                    ]
                ],
            ],

            'tasks' => [
                [
                    'icon'    => 'console',
                    'action'  => '\Distilleries\Expendable\Http\Controllers\Admin\ComponentController@getIndex',
                    'libelle' => _('Generate a new component'),

                ],
                [
                    'icon'    => 'retweet',
                    'action'  => '\Distilleries\Expendable\Http\Controllers\Admin\ServiceController@getSynchronize',
                    'libelle' => _('Synchronize all services'),

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