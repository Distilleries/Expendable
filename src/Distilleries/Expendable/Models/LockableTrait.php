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
        \DB::table($this->getTable())
            ->where($this->getKeyName(), $this->getKey())
            ->increment($this->column_nb_of_try_name);
        return $this;

    }

    public function unlock()
    {

        \DB::table($this->getTable())
            ->where($this->getKeyName(), $this->getKey())
            ->decrement($this->column_nb_of_try_name, $this->{$this->column_nb_of_try_name});

        $this->{$this->column_nb_of_try_name} = 0;
        return $this;

    }

    public function lock()
    {
        $this->{$this->column_nb_of_try_name} = config($this->config_key_security_lock) + 1;

        \DB::table($this->getTable())
            ->where($this->getKeyName(), $this->getKey())
            ->increment($this->column_nb_of_try_name, $this->{$this->column_nb_of_try_name} );

        return $this;
    }

} 