<?php


namespace Distilleries\Expendable\Scopes;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ScopeInterface;
use Illuminate\Database\Eloquent\Model;
use Distilleries\Expendable\Helpers\PermissionUtils;

class StatusScope implements ScopeInterface {

    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        if(!PermissionUtils::hasDisplayAllStatus()){
            $builder->where($model->getStatusColumn(),'=',true);
        }

    }

    /**
     * Remove the scope from the given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    public function remove(Builder $builder, Model $model)
    {

    }
}