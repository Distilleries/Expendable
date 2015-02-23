<?php


namespace Distilleries\Expendable\Helpers;

use \Auth, \Session;

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

    public static function hasAccess($key)
    {
        return Auth::user()->hasAccess($key);
    }

    public static function isNotSuperAdmin()
    {
        return Auth::user()->role->initials != '@sa';
    }



} 