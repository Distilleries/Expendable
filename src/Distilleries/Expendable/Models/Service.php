<?php namespace Distilleries\Expendable\Models;

class Service extends BaseModel {

    protected $fillable = ['id', 'action'];

    public function permissions()
    {
        return $this->hasMany('Distilleries\Expendable\Models\Permission');
    }

    public function getByAction($action) {
        return $this->where('action', '=', $action)->get();
    }
}