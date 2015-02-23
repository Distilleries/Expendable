<?php namespace Distilleries\Expendable\Models;

class Service extends BaseModel {

    protected $fillable = ['id'];

    public function permissions()
    {
        return $this->hasMany('Permission');
    }

    public function getByAction($action){
        return $this->where('action','=',$action)->get();
    }
}