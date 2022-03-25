<?php

namespace Ins0mniac\ServiceGenerator\Console\Commands\ServiceCommands;

use Ins0mniac\ServiceGenerator\Console\Commands\ServiceCommands\Objects\CreatorConstants;
use Ins0mniac\ServiceGenerator\Console\Commands\ServiceCommands\Objects\Generator;
use Ins0mniac\ServiceGenerator\Console\Commands\ServiceCommands\Objects\Publisher;
use Ins0mniac\ServiceGenerator\Console\Commands\ServiceCommands\Traits\UseTraits;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class CreateInterface extends Command
{
    use UseTraits;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:interface
    {interface? : The name of the interface.},
    {--service},
    {service? : The name of the service.},
    {provider? : The name of the provider.},
    {implementation? : Set the type of implementation (bind or singleton).},
    ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new interface';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->constants = new CreatorConstants();
        $this->generator = new Generator();
        $this->publisher = new Publisher();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->getParameters();

        //check what types of files should be generated
        if ($this->isOnlyInterface()) {
            return $this->generatePlainByParameter($this->constants::INTERFACE_WORD);
        }

        $this->checkOrGenerateIt($this->constants::INTERFACE_WORD);

        $interfaceInformation = $this->publisher->getInterfaceInformation();
        $this->checkOrGenerateIt(
            $this->constants::SERVICE_WORD, 'WithImplementation',
            $this->interface . $this->constants::INTERFACE_UC_FIRST,
            $interfaceInformation[$this->constants::NAMESPACE_WORD]);

        $this->checkOrGenerateIt($this->constants::PROVIDER_WORD);

        $this->setPublishImplementation($this->implementation);

        $this->publisher->configProviderInAppFile();

        $this->publisher->attachDependency();

        return 0;
    }

    protected function isOnlyInterface(): bool
    {
        return !$this->service;
    }

    protected function getParameters()
    {
        $this->namespace = $this->laravel->getNamespace();

        $this->interface = $this->getParameter($this->constants::INTERFACE_WORD);
        $this->service = $this->getParameter($this->constants::SERVICE_WORD);
        $this->provider = $this->getParameter($this->constants::PROVIDER_WORD);
        $this->implementation = $this->getParameter($this->constants::IMPLEMENTATION_WORD);

        $this->askForParameters();
    }

    protected function askForParameters()
    {
        if (!$this->interface) {
            $this->interface = $this->askForParameter($this->constants::INTERFACE_WORD);
        }

        $this->interface = Str::camel($this->interface);
        $this->interface = Str::studly($this->interface);

        if (!$this->option($this->constants::SERVICE_WORD)) {
            return;
        }
        $this->serviceLocation = $this->defaultServiceLocation;

        if (!$this->service) {
            $this->service = $this->askForParameterYorN($this->constants::SERVICE_WORD);
        }

        $this->defaultServiceLocation = $this->serviceLocation;

        $this->service = Str::camel($this->service);
        $this->service = Str::studly($this->service);

        if (!$this->provider) {
            $this->provider = $this->askForParameterYorN($this->constants::PROVIDER_WORD);
        }
        $this->provider = Str::camel($this->provider);
        $this->provider = Str::studly($this->provider);

        if ($this->provider) {
            if (!$this->implementation) {
                $this->implementation = $this->askForImplementation();
            }
        }

        $this->implementation = Str::camel($this->implementation);
        $this->implementation = Str::lower($this->implementation);
    }
}
