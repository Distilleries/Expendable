<?php namespace Distilleries\Expendable\Listeners;

use Distilleries\Expendable\Contracts\LockableContract;
use Distilleries\Expendable\Helpers\UserUtils;
use Distilleries\Expendable\Models\User;

class UserListener extends BaseListener
{

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
        'user.login'    => [
            'action'   => 'handleLogin',
            'priority' => 0,
        ],
        'user.logout'   => [
            'action'   => 'handleLogOut',
            'priority' => 0,
        ],
        'user.security' => [
            'action'   => 'handleLockIncrement',
            'priority' => 0,
        ]
    ];

    public function handleLogin(LockableContract $model)
    {


        if ($model->email != '') {
            $model->unlock();
        }

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

    public function handleLockIncrement($email)
    {
        $model = app('Distilleries\Expendable\Contracts\LockableContract');
        $user  = $model->where('email', $email)->get()->last();

        if (!empty($user))
        {
            $user->incrementLock();
        }
    }
}
