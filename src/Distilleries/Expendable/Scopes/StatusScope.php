<?php


namespace Distilleries\Expendable\Scopes;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ScopeInterface;
use Distilleries\Expendable\Helpers\PermissionUtils;

class StatusScope implements ScopeInterface {

    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    public function apply(Builder $builder)
    {
        if(!PermissionUtils::hasDisplayAllStatus()){
            $model = $builder->getModel();
            $builder->where($model->getStatusColumn(),'=',true);
        }

    }

    /**
     * Remove the scope from the given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    public function remove(Builder $builder)
    {

    }
}