<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/


$router->get('storage/{path}', 'Front\AssetController@getIndex')->where('path', '([A-z\d-\/_.\s]+)?');
$router->group(array(
    'prefix' => config('expendable.admin_base_uri'),
    'middleware' => 'guest'
), function() use ($router){

    $router->controller('login', 'Admin\LoginController', [
        'getIndex'  => 'login.index',
        'getRemind' => 'login.remind',
        'getLogout' => 'login.logout',
        'getReset'  => 'login.reset',
    ]);
    $router->get('', 'Admin\LoginController@getLoginRedirect');
    $router->get('set-lang/{locale?}', 'Admin\LanguageController@getChangeLang');

});

$router->group(array('middleware' => 'auth'), function() use($router)
{
    $router->group(array('middleware' => 'permission', 'prefix' => config('expendable.admin_base_uri')), function() use($router)
    {
        $router->controller('user', 'Admin\UserController', [
            'getProfile' => 'user.profile'
        ]);
        $router->controller('email', 'Admin\EmailController');
        $router->controller('component', 'Admin\ComponentController');
        $router->controller('role', 'Admin\RoleController');
        $router->controller('service', 'Admin\ServiceController');
        $router->controller('permission', 'Admin\PermissionController');
        $router->controller('language', 'Admin\LanguageController');
    });
});



\View::composer('expendable::admin.layout.default', function($view)
{
    $view->with('title', '')
        ->with('user', \Auth::user());
});
