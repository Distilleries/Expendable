<?php

namespace Distilleries\Expendable\Models;

use Distilleries\Expendable\Scopes\StatusScope;

trait StatusTrait
{
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
     * Get a new query builder that only includes offline items.
     *
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public static function onlyOffline()
    {

        $instance = new static;

        $column = $instance->getQualifiedStatusColumn();

        return $instance->withoutGlobalScope(StatusScope::class)->where($column, false);
    }

    /**
     * Get a new query builder that include offline and online items.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function offlineAndOnline()
    {
        $instance = new static;

        return $instance->withoutGlobalScope(StatusScope::class);
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
