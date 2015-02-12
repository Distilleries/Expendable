<?php


namespace Distilleries\Expendable\Models;

use \DB, \Exception;

class BaseModel extends \Eloquent {

    /**
     * @return string
     */
    public function getFillable()
    {
        return $this->fillable;
    }

    public static function getChoice()
    {

        $data   = self::all();
        $result = [];
        foreach ($data as $item)
        {
            $result[$item['id']] = isset($item['libelle']) ? $item['libelle'] : $item['id'];
        }

        return $result;
    }

    public function scopeSearch($query, $searchQuery)
    {

        return $query->where(function ($query) use ($searchQuery)
        {
            $columns = $this->getAllColumnsNames();

            foreach ($columns as $column)
            {
                $query->orwhere($column, 'like', '%' . $searchQuery . '%');
            }
        });
    }

    public function getAllColumnsNames()
    {
        switch (DB::connection()->getConfig('driver'))
        {
            case 'pgsql':
                $query       = "SELECT column_name FROM information_schema.columns WHERE table_name = '" . $this->getTable() . "'";
                $column_name = 'column_name';
                $reverse     = true;
                break;

            case 'mysql':
                $query       = 'SHOW COLUMNS FROM ' . $this->getTable();
                $column_name = 'Field';
                $reverse     = false;
                break;

            case 'sqlsrv':
                $parts       = explode('.', $this->getTable());
                $num         = (count($parts) - 1);
                $table       = $parts[$num];
                $query       = "SELECT column_name FROM " . DB::connection()->getConfig('database') . ".INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = N'" . $table . "'";
                $column_name = 'column_name';
                $reverse     = false;
                break;

            default:
                $error = 'Database driver not supported: ' . DB::connection()->getConfig('driver');
                throw new Exception($error);
                break;
        }

        $columns = array();

        foreach (DB::select($query) as $column)
        {
            $columns[] = $column->$column_name;
        }

        if ($reverse)
        {
            $columns = array_reverse($columns);
        }

        return $columns;
    }

    public function scopeBetweenCreate($query, $start, $end)
    {
        return $query->whereBetween($this->getTable().'.created_at', array($start, $end));
    }

    public function scopeBetweenupdate($query, $start, $end)
    {
        return $query->whereBetween($this->getTable().'.updated_at', array($start, $end));
    }

} 