<?php

namespace Ins0mniac\ServiceGenerator\Console\Commands\ServiceCommands\Traits;

use Illuminate\Support\Str;

trait GetAndSetParameterAndLocation
{
    protected function getParameterAndLocation($parameter)
    {
        if (is_numeric($value = $this->argument($parameter))) {
            $value = $this->askForValidParameter($parameter);
        }
        return $this->getParameterAndSetLocation($parameter, $value);
    }

    protected function getParameterAndSetLocation($parameter, $value)
    {
        $paramArray = explode('/', $value);
        $paramName = \Arr::last($paramArray);

        array_pop($paramArray);

        if (count($paramArray) > 0) {
            $paramArray = array_map(function ($el) {
                return Str::ucfirst($el);
            }, $paramArray);
            $this->{$parameter . 'Location'} =
                (($this->{$parameter . 'Location'} !== null) ? $this->{$parameter . 'Location'} . '\\' : '')
                . implode('\\', $paramArray);
        } else {
            $this->{$parameter . 'Location'} = $this->{'default' . Str::ucfirst($parameter) . 'Location'};
        }

        return $paramName;
    }

}
