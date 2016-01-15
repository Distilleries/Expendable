<?php namespace Distilleries\Expendable\Models;


trait LockableTrait
{
    protected $config_key_security_lock = 'expendable.auth.nb_of_try';
    protected $column_nb_of_try_name = 'nb_of_try';

    public function isLocked()
    {

        return ($this->{$this->column_nb_of_try_name} >= config($this->config_key_security_lock));

    }

    public function incrementLock()
    {

        $this->{$this->column_nb_of_try_name} += 1;
        $this->save();

        return $this;
    }

    public function unlock()
    {
        $this->{$this->column_nb_of_try_name} = 0;
        $this->save();

        return $this;

    }

    public function lock()
    {
        $this->{$this->column_nb_of_try_name} = config($this->config_key_security_lock) + 1;
        $this->save();

        return $this;
    }

} 