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


$router->get('storage/{path}', 'Frontend\AssetController@getIndex')->where('path', '([A-z\d-\/_.\s]+)?');
$router->group(array(
    'prefix' => config('expendable.admin_base_uri'),
    'middleware' => 'guest'
), function() use ($router){

    $router->controller('login', 'Backend\LoginController', [
        'getIndex'  => 'login',
        'getRemind' => 'login.remind',
        'getLogout' => 'login.logout',
        'getReset'  => 'password.reset',
    ]);
    $router->get('', 'Backend\LoginController@getLoginRedirect');
    $router->get('set-lang/{locale?}', 'Backend\LanguageController@getChangeLang');

});

$router->group(array('middleware' => ['auth', 'language']), function() use($router)
{
    $router->group(array('middleware' => 'permission', 'prefix' => config('expendable.admin_base_uri')), function() use($router)
    {
        $router->controller('user', 'Backend\UserController', [
            'getProfile' => 'user.profile'
        ]);
        $router->controller('component', 'Backend\ComponentController');
        $router->controller('role', 'Backend\RoleController');
        $router->controller('service', 'Backend\ServiceController');
        $router->controller('permission', 'Backend\PermissionController');
        $router->controller('language', 'Backend\LanguageController');
        $router->get('set-lang/{locale?}', 'Backend\LanguageController@getChangeLang');
    });
});



\View::composer('expendable::admin.layout.default', function($view)
{
    $view->with('title', '')
        ->with('user', \Auth::user());
});
