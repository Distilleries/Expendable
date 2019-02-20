<?php namespace Distilleries\Expendable\Scopes;

use Distilleries\Expendable\Helpers\UserUtils;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;

class StatusScope implements Scope {

    /**
     * All of the extensions to be added to the builder.
     *
     * @var array
     */
    protected $extensions = ['WithOffline', 'OnlyOffline'];


    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $builder
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        if (!UserUtils::hasDisplayAllStatus())
        {
            $builder->where($model->getQualifiedStatusColumn(), true);
        }
        $this->extend($builder);

    }

    /**
     * Extend the query builder with the needed functions.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    public function extend(Builder $builder)
    {
        foreach ($this->extensions as $extension)
        {
            $this->{"add{$extension}"}($builder);
        }

    }


    /**
     * Add the with-trashed extension to the builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addWithOffline(Builder $builder)
    {
        $builder->macro('withOffline', function(Builder $builder)
        {
            return $builder->withoutGlobalScope($this);
        });
    }


    /**
     * Add the only-trashed extension to the builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addOnlyOffline(Builder $builder)
    {
        $builder->macro('onlyOffline', function(Builder $builder)
        {
            $model = $builder->getModel();

            $builder->withoutGlobalScope($this)
                ->where($model->getQualifiedStatusColumn(), '=', false);

            return $builder;
        });
    }

}