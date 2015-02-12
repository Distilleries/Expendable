<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function ($request)
{
    $autoLoaderListener = new \Distilleries\Expendable\Register\ListenerAutoLoader(Config::get('expendable::listener'));
    $autoLoaderListener->load();
});


App::after(function ($request, $response)
{
    //
});

App::error(function (Exception $exception, $code)
{
    if (Request::segment(1) == Config::get('backend.admin_base_uri') and !Config::get('app.debug'))
    {
        return App::make('Distilleries\Expendable\Controllers\AdminErrorController')->callAction("display", [$exception, $code]);
    }


});



/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('admin.auth', function ()
{
    if (!Auth::administrator()->check())
    {
        if (Request::ajax())
        {
            return Response::make('Unauthorized', 401);
        } else
        {
            return Redirect::guest(Config::get('expendable::login_uri'));
        }
    }
});

Route::filter('admin.auth.redirect', function ()
{
    if (Auth::administrator()->check() and Route::current()->getActionName() != 'Admin\LoginController@getLogout')
    {
        $menu = Config::get('expendable::menu');
        return Redirect::to(Auth::administrator()->get()->getFirstRedirect($menu['left']));
    }
});

Route::filter('auth.anthorized', function ()
{
    if (!Auth::administrator()->check() or !Auth::administrator()->get()->hasAccess(Route::getCurrentRoute()->getActionName()))
    {
        App::abort(403, Lang::get('expendable::errors.unthorized'));
    }
});

Route::filter('auth.basic', function ()
{
    return Auth::basic();
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function ()
{
    if (Auth::check()) return Redirect::to('/');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function ()
{
    if (Session::token() !== Input::get('_token'))
    {
        throw new Illuminate\Session\TokenMismatchException;
    }
});
