<?php
/**
 * Created by PhpStorm.
 * User: mfrancois
 * Date: 29/01/2015
 * Time: 1:53 PM
 */

namespace Distilleries\Expendable\Models;


use Distilleries\Expendable\Scopes\StatusScope;

trait StatusTrait {

    /**
     * Boot the soft deleting trait for a model.
     *
     * @return void
     */
    public static function bootStatusTrait()
    {
        static::addGlobalScope(new StatusScope);
    }


    /**
     * Get a new query builder that only includes soft deletes.
     *
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public static function onlyOffline()
    {
        $instance = new static;

        $column = $instance->getQualifiedStatusColumn();

        return $instance->newQueryWithoutScope(new StatusScope)->where($column,'=',false);
    }

    public static function offlineAndOnline()
    {
        $instance = new static;

        $column = $instance->getQualifiedStatusColumn();

        return $instance->newQueryWithoutScope(new StatusScope);
    }

    /**
     * Get the fully qualified "deleted at" column.
     *
     * @return string
     */
    public function getQualifiedStatusColumn()
    {
        return $this->getTable().'.'.$this->getStatusColumn();
    }

    /**
     * Get the name of the "deleted at" column.
     *
     * @return string
     */
    public function getStatusColumn()
    {
        return defined('static::STATUS') ? static::STATUS : 'status';
    }

} 