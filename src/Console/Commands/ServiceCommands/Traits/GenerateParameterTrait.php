<?php

namespace Ins0mniac\ServiceGenerator\Console\Commands\ServiceCommands\Traits;

trait GenerateParameterTrait
{
    protected function generatePlainByParameter($parameter)
    {
        $message = $this->generator->generatePlain($this->prepareDataForExecution($this->{$parameter}, $this->{$parameter . 'Location'}, $parameter));
        return $this->generateFileMessage($parameter, $message);
    }
}
