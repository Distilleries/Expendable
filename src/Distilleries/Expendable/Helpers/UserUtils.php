<?php


namespace Distilleries\Expendable\Helpers;

use \Auth, \Session;

class UserUtils {

    public static function get()
    {
        return Auth::administrator()->get();
    }

    public static function getEmail()
    {
        return Auth::administrator()->get()->getReminderEmail();
    }

    public static function getDisplayName()
    {
        return Auth::administrator()->get()->getReminderEmail();
    }

    public static function hasAccess($key)
    {
        return Auth::administrator()->get()->hasAccess($key);
    }

    public static function isNotSuperAdmin()
    {
        return Auth::administrator()->get()->role->initials != '@sa';
    }



} 