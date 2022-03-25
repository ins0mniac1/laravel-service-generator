<?php

namespace Ins0mniac\ServiceGenerator\Console\Commands\ServiceCommands\Objects\HelpersTrait;

trait GetStringsTrait
{
    protected function searchingString(): string
    {
        return '
        /*
         * Custom Service Providers...
         */';
    }

    protected function searchingBindString(): string
    {
        return '
        /*
         * All Bindings dependencies
         */';
    }

    protected function searchingSingletonString(): string
    {
        return '
        /*
         * All Singletons dependencies
         */';
    }

    protected function defaultUsingString(): string
    {
        return 'use Illuminate\Support\ServiceProvider;';
    }
}
