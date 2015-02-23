<?php namespace Distilleries\Expendable\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends BaseModel implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword, \Distilleries\Expendable\Models\StatusTrait;

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
		return $this->belongsTo('Role');
	}

	public static function boot()
	{
		parent::boot();
		self::observe(new \Distilleries\Expendable\Observers\PasswordObserver);
	}
}
