<?php

namespace Ins0mniac\ServiceGenerator\Console\Commands\ServiceCommands\Traits;

trait CheckForFileOrGenerateItTrait
{
    protected function checkOrGenerateIt($parameter, $type = 'plain', $implementation = null, $implementationNamespace = '')
    {
        $preparedData = $this->prepareDataForExecution(
            $this->{$parameter},
            $this->{$parameter . 'Location'},
            $parameter,
            $implementation,
            $implementationNamespace);

        $message = $this->generator->{'generate' . \Str::ucfirst($type)}($preparedData);

        if ($message['status'] === 'success') {
            $this->generateFileMessage($parameter, $message);
        }

        $this->setPublishParameter($parameter, [
            'file' => $message['file'],
            'name' => $preparedData['name'],
            'location' => $preparedData['location'],
            'namespace' => $this->generator->getNamespace($preparedData),
        ]);
    }

    protected function checkForFile($parameter): bool
    {
        $preparedData = $this->prepareDataForExecution($this->{$parameter}, $this->{$parameter . 'Location'}, $parameter);
        return $this->generator->check($this->generator->prepareData($preparedData)['destination']);
    }
}
