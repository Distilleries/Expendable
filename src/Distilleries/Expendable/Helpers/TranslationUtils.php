<?php namespace Distilleries\Expendable\Helpers;

class TranslationUtils {

    const KEY_OVERRIDE_LOCAL = 'local_override';

    public static function overrideLocal($iso)
    {
        config([self::KEY_OVERRIDE_LOCAL => $iso]);

    }

    public static function resetOverrideLocal()
    {
        config([self::KEY_OVERRIDE_LOCAL => null]);
    }


}