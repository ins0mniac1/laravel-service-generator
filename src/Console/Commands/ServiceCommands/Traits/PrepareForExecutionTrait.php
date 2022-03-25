<?php

namespace Ins0mniac\ServiceGenerator\Console\Commands\ServiceCommands\Traits;

use Illuminate\Support\Str;

trait PrepareForExecutionTrait
{
    protected function prepareDataForExecution($name, $location, $type, $implementation = null, $implementationNamespace = ''): array
    {
        return [
            'type' => $type,
            'name' => Str::finish($name, Str::ucfirst($type)),
            'location' => $location,
            'namespace' => $this->namespace,
            'implementation' => $implementation,
            'implementationNamespace' => $implementationNamespace,
        ];
    }
}
