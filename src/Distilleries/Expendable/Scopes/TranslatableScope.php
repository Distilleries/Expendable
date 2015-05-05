<?php namespace Distilleries\Expendable\Scopes;

use Illuminate\Database\Eloquent\ScopeInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class TranslatableScope implements ScopeInterface {

    /**
     * All of the extensions to be added to the builder.
     *
     * @var array
     */
    protected $extensions = ['WithoutTranslation'];

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
        //Check if is an override
        //
        $iso = config()->get('local_override');

        if (empty($iso)) {
            $iso = app()->getLocale();
        }

        $builder->whereExists(function ($query) use ($model, $iso) {
            $query->select(\DB::raw(1))
                ->from($model->getQualifiedTable())
                ->whereRaw($model->getTable() . '.' . $model->getKeyName() . ' = ' . $model->getQualifiedIdElementColumn())
                ->where($model->getQualifiedIsoColumn(), $iso)
                ->where($model->getQualifiedModelColumn(), $model->getTable());
        });

        $query               = $builder->getQuery();
        $this->where_index   = count($query->wheres) - 1;
        $this->binding_index = count($query->getRawBindings()['where']) - 1;

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
        unset($where_bindings[$this->binding_index-1]);
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
        foreach ($this->extensions as $extension) {
            $this->{"add{$extension}"}($builder);
        }

    }


    /**
     * Add the with-trashed extension to the builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $builder
     * @return void
     */
    protected function addWithoutTranslation(Builder $builder)
    {
        $builder->macro('withoutTranslation', function (Builder $builder) {
            $this->remove($builder, $builder->getModel());

            return $builder;
        });
    }
}