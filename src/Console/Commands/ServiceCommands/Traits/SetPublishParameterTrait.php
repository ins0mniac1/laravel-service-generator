<?php

namespace Ins0mniac\ServiceGenerator\Console\Commands\ServiceCommands\Traits;

trait SetPublishParameterTrait
{
    protected function setPublishParameter($parameter, array $data)
    {
        $this->publisher->{'set' . \Str::ucfirst($parameter) . 'Information'}(
            [
                'file' => $data['file'],
                'name' => $data['name'],
                'location' => $data['location'],
                'namespace' => $data['namespace'],
            ]
        );
    }

    protected function setPublishImplementation($implementation)
    {
        $this->publisher->setImplementation($implementation);
    }
}
