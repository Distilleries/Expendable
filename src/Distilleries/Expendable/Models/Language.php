<?php namespace Distilleries\Expendable\Models;

class Language extends BaseModel {

    use \Distilleries\Expendable\Models\StatusTrait;

    protected $fillable = [
        'libelle',
        'iso',
        'not_visible',
        'is_default',
        'status',
    ];

    public function scopeWithoutCurrentLanguage($query)
    {
        return $query->where($this->getTable().'.iso', '<>', app()->getLocale());
    }

    public function scopeWithTranslationElement($query)
    {
        return $query->where($this->getTable().'.iso', '<>', app()->getLocale());
    }
}