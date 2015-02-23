<?php namespace Distilleries\Expendable\Helpers;

class StaticLabel {

    const STATUS_OFFLINE = 0;
    const STATUS_ONLINE = 1;

    const BODY_TYPE_HTML = 'html';
    const BODY_TYPE_TEXT = 'text';

    public static function status($id = null)
    {
        $items = [
            self::STATUS_OFFLINE => _('Offline'),
            self::STATUS_ONLINE  => _('Online'),
        ];

        return self::getLabel($items, $id);

    }

    public static function typeExport($id = null)
    {
        $items = [
            'Distilleries\Expendable\Contracts\ExcelExporterContract' => _('Excel'),
            'Distilleries\Expendable\Contracts\CsvExporterContract'   => _('Csv')
        ];

        return self::getLabel($items, $id);

    }


    public static function yesNo($id = null)
    {
        $items = [
            self::STATUS_OFFLINE => _('No'),
            self::STATUS_ONLINE  => _('Yes'),
        ];

        return self::getLabel($items, $id);

    }


    public static function bodyType($id = null)
    {
        $items = [
            self::BODY_TYPE_HTML => _('Html'),
            self::BODY_TYPE_TEXT => _('Text'),
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
            $dataResult[$key] = $action['libelle'];
        }

        return self::getLabel($dataResult, $id);
    }


    public static function getLabel($items, $id = null)
    {
        if (isset($id))
        {
            return isset($items[$id]) ? $items[$id] : _('n/a');
        }

        return $items;
    }
}