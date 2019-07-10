<?php namespace Distilleries\Expendable\Helpers;

use \Auth;
use \Session;

class UserUtils
{


    public static function isBackendRole()
    {
        $user = Auth::user();

        if (empty($user)) {
            return false;
        }

        return !empty(Auth::user()->role) && (Auth::user()->role->initials == '@sa' || Auth::user()->role->initials == '@a');
    }

    public static function frontendInitialRole()
    {
        return [
            '@g', //guest
        ];
    }

    public static function isFrontendRole()
    {
        $user = Auth::user();

        if (empty($user)) {
            return false;
        }

        return !empty(Auth::user()->role) && in_array(Auth::user()->role->initials, self::frontendInitialRole());
    }



    public static function get()
    {
        return Auth::user();
    }

    public static function getEmail()
    {
        return Auth::user()->getEmailForPasswordReset();
    }

    public static function getDisplayName()
    {
        return Auth::user()->getEmailForPasswordReset();
    }

    public static function isNotSuperAdmin()
    {
        return !empty(Auth::user()->role) && Auth::user()->role->initials != '@sa';
    }


    public static function setArea($area)
    {
        Session::put('permissions', $area);
    }

    public static function getArea()
    {
        return Session::get('permissions');
    }

    public static function forgotArea()
    {
        Session::forget('permissions');
    }

    public static function hasAccess($key)
    {
        $key  = ltrim($key, "\\");
        $area = self::getArea();
        $area = (is_array($area) && !empty($area)) ? $area : [];

        return in_array($key, $area);
    }

    public static function hasDisplayAllStatus()
    {
        return Session::get('display_all_status', false);
    }

    public static function forgotDisplayAllStatus()
    {
        Session::forget('display_all_status');
    }

    public static function setDisplayAllStatus()
    {
        Session::put('display_all_status', true);
    }

    public static function setIsLoggedIn()
    {
        if (session_id() == '')
        {
            @session_start();

        }

        $_SESSION['isLoggedIn'] = true;
    }

    public static function forgotIsLoggedIn()
    {
        $session_id = session_id();

        if (!empty($session_id))
        {
            unset($_SESSION['isLoggedIn']);
        }

    }

    public static function securityCheckLockEnabled()
    {
        return config('expendable.auth.security_enabled') === true;
    }
}