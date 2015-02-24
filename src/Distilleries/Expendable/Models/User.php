<?php namespace Distilleries\Expendable\Models;

use Distilleries\Expendable\Helpers\UserUtils;
use Distilleries\PermissionUtil\Contracts\PermissionUtilContract;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends BaseModel implements AuthenticatableContract, CanResetPasswordContract, PermissionUtilContract {

    use Authenticatable, CanResetPassword, \Distilleries\Expendable\Models\StatusTrait;

    protected $tabPermission = [];
    protected $fillable = [
        'email',
        'password',
        'status',
        'role_id'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public function role()
    {
        return $this->belongsTo('Distilleries\Expendable\Models\Role');
    }

    public static function boot()
    {
        parent::boot();
        self::observe(new \Distilleries\Expendable\Observers\PasswordObserver);
    }



    public function hasAccess($key)
    {

        if (!empty($this->role->overide_permission))
        {
            return true;
        }

        return UserUtils::hasAccess($key);
    }

    public function getFirstRedirect($left)
    {
        foreach ($left as $item)
        {

            if (!empty($item['action']) and $this->hasAccess($item['action']))
            {
                return preg_replace('/\/index/i', '', action($item['action']));

            } else if (!empty($item['submenu']))
            {
                $redirect = $this->getFirstRedirect($item['submenu']);

                if (!empty($redirect))
                {
                    return $redirect;
                }

            }

        }

        return '';
    }
}
