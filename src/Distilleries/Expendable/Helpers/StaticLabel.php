<?php namespace Distilleries\Expendable\Helpers;

class StaticLabel {

    const STATUS_OFFLINE = 0;
    const STATUS_ONLINE = 1;

    const BODY_TYPE_HTML = 'html';
    const BODY_TYPE_TEXT = 'text';

    public static function status($id = null)
    {
        $items = [
            self::STATUS_OFFLINE => trans('expendable::label.offline'),
            self::STATUS_ONLINE  => trans('expendable::label.online'),
        ];

        return self::getLabel($items, $id);

    }

    public static function typeExport($id = null)
    {
        $items = [
            'xls' => trans('expendable::label.excel'),
            'csv'   => trans('expendable::label.csv')
        ];

        return self::getLabel($items, $id);

    }


    public static function yesNo($id = null)
    {
        $items = [
            self::STATUS_OFFLINE => trans('expendable::label.no'),
            self::STATUS_ONLINE  => trans('expendable::label.yes'),
        ];

        return self::getLabel($items, $id);

    }


    public static function bodyType($id = null)
    {
        $items = [
            self::BODY_TYPE_HTML => trans('expendable::label.html'),
            self::BODY_TYPE_TEXT => trans('expendable::label.text'),
        ];

        return self::getLabel($items, $id);
    }

    public static function mailActions($id = null)
    {
        $config      = app('config')->get('expendable.mail');
        $dataActions = $config['actions'];
        $dataResult  = [];

        foreach ($dataActions as $action)
        {
            $dataResult[$action] = trans('expendable::mail.'.$action);
        }

        return self::getLabel($dataResult, $id);
    }

    public static function states($id = null)
    {
        $config      = app('config')->get('expendable.state');
        $dataActions = $config;
        $dataResult  = [];

        foreach ($dataActions as $key => $action)
        {
            $dataResult[$key] = trans($action['libelle']);
        }

        return self::getLabel($dataResult, $id);
    }


    public static function getLabel($items, $id = null)
    {
        if (isset($id))
        {
            return isset($items[$id]) ? $items[$id] : trans('expendable::label.na');
        }

        return $items;
    }
}