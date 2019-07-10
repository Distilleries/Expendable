<?php namespace Distilleries\Expendable\Scopes;

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class TranslatableScope implements Scope {

    /**
     * All of the extensions to be added to the builder.
     *
     * @var array
     */
    protected $extensions = ['WithoutTranslation'];


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

        $builder->whereExists(function($query) use ($model, $iso) {
            $query->select(\DB::raw(1))
                ->from($model->getQualifiedTable())
                ->whereRaw($model->getTable().'.'.$model->getKeyName().' = '.$model->getQualifiedIdElementColumn())
                ->where($model->getQualifiedIsoColumn(), $iso)
                ->where($model->getQualifiedModelColumn(), $model->getTable());
        });

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
        $builder->macro('withoutTranslation', function(Builder $builder) {
            return $builder->withoutGlobalScope($this);
        });
    }
}