<?php


namespace Distilleries\Expendable\Scopes;


use Distilleries\Expendable\Helpers\UserUtils;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ScopeInterface;
use Illuminate\Database\Eloquent\Model;


class StatusScope implements ScopeInterface {

    /**
     * All of the extensions to be added to the builder.
     *
     * @var array
     */
    protected $extensions = ['WithOffline', 'OnlyOffline'];

    /**
     * The index in which we added a where clause
     * @var int
     */
    private $where_index;

    /**
     * The index in which we added a where binding
     * @var int
     */
    private $binding_index;

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
            $query               = $builder->getQuery();
            $this->where_index   = count($query->wheres) - 1;
            $this->binding_index = count($query->getRawBindings()['where']) - 1;
        }

        $this->extend($builder);

    }

    /**
     * Remove the scope from the given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    public function remove(Builder $builder, Model $model)
    {
        $query = $builder->getQuery();

        unset($query->wheres[$this->where_index]);
        $where_bindings = $query->getRawBindings()['where'];
        unset($where_bindings[$this->binding_index]);
        $query->setBindings(array_values($where_bindings));
        $query->wheres = array_values($query->wheres);


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
            $this->remove($builder, $builder->getModel());

            return $builder;
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

            $this->remove($builder, $model);

            $builder->getQuery()->where($model->getQualifiedStatusColumn(), '=', false);

            return $builder;
        });
    }

}