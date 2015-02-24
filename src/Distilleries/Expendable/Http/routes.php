<?php

use \Route;
use \View;
use \Auth;

Route::get('app/storage/{path}', 'Front\AssetController@getIndex')->where('path', '([A-z\d-\/_.\s]+)?');

Route::group(array(
    'prefix' => 'admin',
    'middleware' => 'guest'
), function ()
{
    Route::get('', function ()
    {
        return Redirect::to(route('login.index'));
    });

    Route::controller('login', 'Admin\LoginController', [
        'getIndex'  => 'login.index',
        'getRemind' => 'login.remind',
        'getLogout' => 'login.logout',
        'getReset'  => 'login.reset',
    ]);
    Route::get('set-lang/{locale?}', 'Admin\LanguageController@getChangeLang');

});

Route::group(array('middleware' => 'auth'), function ()
{
    Route::group(array('middleware' => 'permission', 'prefix' => config('expendable.admin_base_uri')), function ()
    {
        Route::controller('user', 'Admin\UserController', [
            'getProfile' => 'user.profile'
        ]);
        Route::controller('email', 'Admin\EmailController');
        Route::controller('component', 'Admin\ComponentController');
        Route::controller('role', 'Admin\RoleController');
        Route::controller('service', 'Admin\ServiceController');
        Route::controller('permission', 'Admin\PermissionController');
        Route::controller('language', 'Admin\LanguageController');
    });
});


View::composer('expendable::admin.layout.default', function ($view)
{
    $view->with('title', '')
        ->with('user', Auth::user());
});
