<?php namespace Distilleries\Expendable\Helpers;

use \Auth;
use \Session;

class UserUtils {

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
        return Auth::user()->role->initials != '@sa';
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
}