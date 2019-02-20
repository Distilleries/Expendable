<?php

namespace Distilleries\Expendable\Scopes;

use Distilleries\Expendable\Contracts\TranslatableObserverContract;
use Distilleries\Expendable\Models\Translation;

trait Translatable
{
    /**
     * Boot the soft deleting trait for a model.
     *
     * @return void
     */
    public static function bootTranslatable()
    {
        static::addGlobalScope(new TranslatableScope);
        try {
            $observer = app(TranslatableObserverContract::class);
            static::observe($observer);
        } catch (\Exception $exception) {}
    }

    /**
     * Get a new query builder that only includes soft deletes.
     *
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public static function withoutTranslation()
    {
        $instance = new static;

        return $instance->withoutGlobalScope(TranslatableScope::class);

    }

    /**
     * Get the fully qualified "iso" column.
     *
     * @return string
     */
    public function getQualifiedIsoColumn()
    {
        $translation = new Translation;

        return $translation->getTable().'.'.$translation->getIsoColumn();
    }

    /**
     * Get the fully qualified "id_element" column.
     *
     * @return string
     */
    public function getQualifiedIdElementColumn()
    {
        $translation = new Translation;

        return $translation->getTable().'.'.$translation->getIdElementColumn();
    }

    /**
     * Get the fully qualified "id_element" column.
     *
     * @return string
     */
    public function getQualifiedModelColumn()
    {
        $translation = new Translation;

        return $translation->getTable().'.'.$translation->getModelColumn();
    }

    /**
     * Get the fully qualified "id_source" column.
     *
     * @return string
     */
    public function getQualifiedIdSourceColumn()
    {
        $translation = new Translation;

        return $translation->getTable().'.'.$translation->getIdSourceColumn();
    }

    /**
     * Get the fully qualified "table" column.
     *
     * @return string
     */
    public function getQualifiedTable()
    {
        $translation = new Translation;

        return $translation->getTable();
    }

    public function setTranslation($id_element, $model, $id_source, $iso)
    {

        $translation = Translation::where($this->getQualifiedIdElementColumn(), '=', $id_element)
            ->where($this->getQualifiedModelColumn(), '=', $model)
            ->where($this->getQualifiedIsoColumn(), '=', $iso)->get();

        if (!$translation->isEmpty()) {
            $translation->each(function($trans) {
                $trans->delete();
            });
        }


        $translation             = new Translation;
        $translation->id_element = $id_element;
        $translation->model      = $model;
        $translation->id_source  = $id_source;
        $translation->iso        = $iso;

        return $translation->save();
    }

    public function getIso($model, $id_element)
    {
        $translation = Translation::where($this->getQualifiedIdElementColumn(), '=', $id_element)
            ->where($this->getQualifiedModelColumn(), '=', $model)->get()->last();

        return (!empty($translation->iso)) ? $translation->iso : false;
    }

    public function hasBeenTranslated($model, $id_source, $iso)
    {
        $translation = Translation::where($this->getQualifiedIdSourceColumn(), '=', $id_source)
            ->where($this->getQualifiedModelColumn(), '=', $model)
            ->where($this->getQualifiedIsoColumn(), '=', $iso)
            ->get()->last();

        return (!empty($translation->id_element)) ? $translation->id_element : false;
    }

    public function hasTranslation($model, $id_element)
    {
        $translation = Translation::where($this->getQualifiedIdElementColumn(), '=', $id_element)
            ->where($this->getQualifiedModelColumn(), '=', $model)->count();

        return (!empty($translation)) ? true : false;
    }
}
