<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/


Route::get('app/storage/{path}', 'Front\AssetController@getIndex')->where('path', '([A-z\d-\/_.\s]+)?');


Route::group(array(
    'prefix' => 'admin',
    'before' => 'admin.auth.redirect'
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


});

Route::group(array('before' => 'admin.auth'), function ()
{

    Route::group(array('before' => 'auth.anthorized', 'prefix' => 'admin'), function ()
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
    $user = Auth::administrator()->get();
    $view->with('title', '')
        ->with('user', $user);
});
