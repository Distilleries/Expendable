<?php

namespace Distilleries\Expendable\Contracts;

interface LockableContract
{
    public function isLocked();

    public function incrementLock();

    public function unlock();

    public function lock();

}
