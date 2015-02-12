<?php


namespace Distilleries\Expendable\Config;


class MenuConfig {

    public static function menu($merge = [], $direction = 'end')
    {

        $first = [
            'left'  => [
                [
                    'icon'    => 'envelope',
                    'action'  => 'Admin\EmailController@getIndex',
                    'libelle' => _('Email'),
                    'submenu' => [
                        [
                            'icon'    => 'th-list',
                            'libelle' => _('List of Email'),
                            'action'  => 'Admin\EmailController@getIndex',
                        ],
                        [
                            'icon'    => 'pencil',
                            'libelle' => _('Add Email'),
                            'action'  => 'Admin\EmailController@getEdit',
                        ]
                    ]
                ],
                [
                    'icon'    => 'user',
                    'action'  => 'Admin\UserController@getIndex',
                    'libelle' => _('User'),
                    'submenu' => [
                        [
                            'icon'    => 'th-list',
                            'libelle' => _('List of user'),
                            'action'  => 'Admin\UserController@getIndex',
                        ],
                        [
                            'icon'    => 'pencil',
                            'libelle' => _('Add User'),
                            'action'  => 'Admin\UserController@getEdit',
                        ],
                        [
                            'icon'    => 'user',
                            'libelle' => _('My Profile'),
                            'action'  => 'Admin\UserController@getProfile',
                        ]

                    ]
                ],
                [
                    'icon'    => 'paperclip',
                    'action'  => 'Admin\RoleController@getIndex',
                    'libelle' => _('Role'),
                    'submenu' => [
                        [
                            'icon'    => 'th-list',
                            'libelle' => _('List of role'),
                            'action'  => 'Admin\RoleController@getIndex',
                        ],
                        [
                            'icon'    => 'pencil',
                            'libelle' => _('Add Role'),
                            'action'  => 'Admin\RoleController@getEdit',
                        ]

                    ]
                ],
                [
                    'icon'    => 'tags',
                    'action'  => 'Admin\PermissionController@getIndex',
                    'libelle' => _('Permission'),
                    'submenu' => [
                        [
                            'icon'    => 'pencil',
                            'libelle' => _('Associate Permission'),
                            'action'  => 'Admin\PermissionController@getIndex',
                        ],
                        [
                            'icon'    => 'th-list',
                            'libelle' => _('List of service'),
                            'action'  => 'Admin\ServiceController@getIndex',
                        ],
                        [
                            'icon'    => 'pencil',
                            'libelle' => _('Add Service'),
                            'action'  => 'Admin\ServiceController@getEdit',
                        ],
                        [
                            'icon'    => 'retweet',
                            'libelle' => _('Synchronize all services'),
                            'action'  => 'Admin\ServiceController@getSynchronize',
                        ]
                    ]
                ],
                [
                    'icon'    => 'flag',
                    'action'  => 'Admin\LanguageController@getIndex',
                    'libelle' => _('Language'),
                    'submenu' => [
                        [
                            'icon'    => 'th-list',
                            'libelle' => _('List of language'),
                            'action'  => 'Admin\LanguageController@getIndex',
                        ],
                        [
                            'icon'    => 'pencil',
                            'libelle' => _('Add Language'),
                            'action'  => 'Admin\LanguageController@getEdit',
                        ]

                    ]
                ],
            ],

            'tasks' => [
                [
                    'icon'    => 'console',
                    'action'  => 'Admin\ComponentController@getIndex',
                    'libelle' => _('Generate a new component'),

                ],
                [
                    'icon'    => 'retweet',
                    'action'  => 'Admin\ServiceController@getSynchronize',
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