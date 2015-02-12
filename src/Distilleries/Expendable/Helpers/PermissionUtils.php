<?php


namespace Distilleries\Expendable\Helpers;

use \Session;

class PermissionUtils {

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

    public static function haveAccess($key)
    {
        $area = self::getArea();
        $area = (is_array($area) and !empty($area)) ? $area : [];

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
        if (session_id() == '')
        {
            @session_start();

        }

        $_SESSION['isLoggedIn'] = false;
        unset($_SESSION['isLoggedIn']);
    }


} 