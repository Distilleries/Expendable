<?php


namespace Distilleries\Expendable\Listeners;


use Distilleries\Expendable\Helpers\PermissionUtils;

class UserListener extends BaseListener {

    /**
     * @var array[
     * 'user.login'=>[
     *      'action'=>'handleLogin',
     *      'priority'=>0
     *  ]
     * ]
     *
     */
    protected $events = [
        'user.login' => [
            'action'   => 'handleLogin',
            'priority' => 0,
        ],
        'user.logout' => [
            'action'   => 'handleLogOut',
            'priority' => 0,
        ]
    ];


    public function handleLogin($model)
    {

        $areaServices = [];
        foreach ($model->role->permissions as $permission)
        {
            $areaServices[] = $permission->service->action;
        }

        PermissionUtils::setArea($areaServices);
        PermissionUtils::setIsLoggedIn();
        PermissionUtils::setDisplayAllStatus();

    }

    public function handleLogOut($model)
    {
        PermissionUtils::forgotArea();
        PermissionUtils::forgotIsLoggedIn();
        PermissionUtils::forgotDisplayAllStatus();
    }
} 