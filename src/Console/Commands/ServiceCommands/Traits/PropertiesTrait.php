<?php

namespace Ins0mniac\ServiceGenerator\Console\Commands\ServiceCommands\Traits;

use Ins0mniac\ServiceGenerator\Console\Commands\ServiceCommands\Objects\CreatorConstants;
use Ins0mniac\ServiceGenerator\Console\Commands\ServiceCommands\Objects\Generator;
use Ins0mniac\ServiceGenerator\Console\Commands\ServiceCommands\Objects\Publisher;

trait PropertiesTrait
{
    protected ?string $interface;
    protected ?string $service;
    protected ?string $provider;
    protected ?string $implementation;

    protected string $defaultServiceLocation = 'Services';
    protected string $defaultInterfaceLocation = 'Services';
    protected string $defaultProviderLocation = 'Providers';

    protected ?string $serviceLocation = null;
    protected ?string $interfaceLocation = null;
    protected ?string $providerLocation = null;

    protected ?string $namespace;

    protected Generator $generator;
    protected Publisher $publisher;
    protected CreatorConstants $constants;
}
