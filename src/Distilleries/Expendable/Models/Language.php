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
}