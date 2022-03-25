<?php

namespace Ins0mniac\ServiceGenerator\Console\Commands\ServiceCommands\Traits;

trait IsParameterNullTrait
{
    protected function isParameterNull($parameter): bool
    {
        if (!$this->argument($parameter)) {
            return true;
        }
        return false;
    }
}
