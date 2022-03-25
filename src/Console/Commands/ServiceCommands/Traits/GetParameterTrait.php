<?php

namespace Ins0mniac\ServiceGenerator\Console\Commands\ServiceCommands\Traits;

trait GetParameterTrait
{
    protected function getParameter($parameter)
    {
        if ($this->isParameterNull($parameter)) {
            return $this->argument($parameter);
        }

        return $this->getParameterAndLocation($parameter);
    }
}
