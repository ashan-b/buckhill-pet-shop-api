<?php

namespace Ashan\StateMachine\Traits;

trait StateMachine
{
    protected $primaryKeyName;

    public function getPrimaryKeyName()
    {
        return $this->primaryKeyName;
    }

}
