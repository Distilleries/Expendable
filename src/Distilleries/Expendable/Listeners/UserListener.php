<?php namespace Distilleries\Expendable\Listeners;

use Distilleries\Expendable\Helpers\UserUtils;

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
        'user.login'  => [
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

        $role = $model->role;

        if (!empty($role))
        {
            foreach ($model->role->permissions as $permission)
            {
                $areaServices[] = $permission->service->action;
            }

        }

        UserUtils::setArea($areaServices);
        UserUtils::setIsLoggedIn();
        UserUtils::setDisplayAllStatus();

    }

    public function handleLogOut()
    {
        UserUtils::forgotArea();
        UserUtils::forgotIsLoggedIn();
        UserUtils::forgotDisplayAllStatus();
    }
}