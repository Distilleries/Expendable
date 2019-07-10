<?php

namespace Distilleries\Expendable\Models;

use Distilleries\Security\Helpers\Security;
use Distilleries\Expendable\Models\Traits\ReservedKeyWord;
use Distilleries\Expendable\Models\Traits\ReservedKeyWordTrait;
use Illuminate\Database\Eloquent\Model;
use \DB;
use \Exception;

class BaseModel extends Model implements ReservedKeyWord
{

    use ReservedKeyWordTrait;


    public static function getChoice()
    {

        $data   = self::all();
        $result = [];
        foreach ($data as $item) {
            $result[$item['id']] = isset($item['libelle']) ? $item['libelle'] : $item['id'];
        }

        return $result;
    }

    public function scopeSearch($query, $searchQuery)
    {

        return $query->where(function($query) use ($searchQuery) {
            $columns = $this->getAllColumnsNames();

            foreach ($columns as $column) {
                $column = $this->isReserved($column) ? '"'.$column.'"' : $column;

                if ((DB::connection()->getDriverName()) == 'oracle') {
                    $query->orWhereRaw('LOWER('.$column.') like ? ESCAPE \'\\\'', ['%'.Security::escapeLike(strtolower($searchQuery)).'%']);
                } else {
                    $query->orwhere($column, 'like', '%'.Security::escapeLike($searchQuery, '\\\'').'%');
                }

            }
        });
    }

    public function getAllColumnsNames()
    {
        switch (DB::connection()->getDriverName()) {
            case 'pgsql':
                $query       = "SELECT column_name FROM information_schema.columns WHERE table_name = '".$this->getTable()."'";
                $column_name = 'column_name';
                $reverse     = true;
                break;

            case 'sqlite':
                $query       = "PRAGMA table_info('".$this->getTable()."')";
                $column_name = 'name';
                $reverse     = true;
                break;


            case 'mysql':
                $query       = 'SHOW COLUMNS FROM '.$this->getTable();
                $column_name = 'Field';
                $reverse     = false;
                break;

            case 'sqlsrv':
                $parts       = explode('.', $this->getTable());
                $num         = (count($parts) - 1);
                $table       = $parts[$num];
                $query       = "SELECT column_name FROM ".DB::connection()->getConfig('database').".INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = N'".$table."'";
                $column_name = 'column_name';
                $reverse     = false;
                break;
            case 'oracle':
                $query       = 'SELECT COLUMN_NAME from ALL_TAB_COLUMNS WHERE TABLE_NAME=\''.strtoupper($this->getTable()).'\' AND DATA_TYPE <> \'CLOB\' AND DATA_TYPE <> \'NUMBER\' AND DATA_TYPE <> \'TIMESTAMP\'';
                $column_name = 'column_name';
                $reverse     = false;
                break;
            default:
                $error = 'Database driver not supported: '.DB::connection()->getConfig('driver');
                throw new Exception($error);
        }

        $columns = [];

        foreach (DB::select($query) as $column) {
            $columns[] = $column->$column_name;
        }

        if ($reverse) {
            $columns = array_reverse($columns);
        }

        return $columns;
    }

    public function scopeBetweenCreate($query, $start, $end)
    {
        return $query->whereBetween($this->getTable().'.created_at', [$start, $end]);
    }

    public function scopeBetweenUpdate($query, $start, $end)
    {
        return $query->whereBetween($this->getTable().'.updated_at', [$start, $end]);
    }


}