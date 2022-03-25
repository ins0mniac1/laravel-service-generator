<?php

namespace Ins0mniac\ServiceGenerator\Console\Commands\ServiceCommands;

use Ins0mniac\ServiceGenerator\Console\Commands\ServiceCommands\Objects\CreatorConstants;
use Ins0mniac\ServiceGenerator\Console\Commands\ServiceCommands\Objects\Generator;
use Ins0mniac\ServiceGenerator\Console\Commands\ServiceCommands\Objects\Publisher;
use Ins0mniac\ServiceGenerator\Console\Commands\ServiceCommands\Traits\UseTraits;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class CreateService extends Command
{
    use UseTraits;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:service
    {service? : The name of the service.},
    {--interface}
    {interface? : The name of the interface.},
    {provider? : The name of the provider.},
    {implementation? : Set the type of implementation (bind or singleton).},
    ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new service';

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
        //Get the parameters
        $this->getParameters();

        if ($this->isOnlyService()) {
            $this->generatePlainByParameter($this->constants::SERVICE_WORD);
            return 0;
        }

        if ($this->checkForFile($this->constants::SERVICE_WORD)) {
            $this->info('The service is already exists!');
            return 0;
        };


        $this->checkOrGenerateIt($this->constants::INTERFACE_WORD);

        $interfaceInformation = $this->publisher->getInterfaceInformation();

        $servicePreparedData = $this->prepareDataForExecution($this->service,
            $this->serviceLocation,
            $this->constants::SERVICE_WORD,
            $this->interface . $this->constants::INTERFACE_UC_FIRST,
            $interfaceInformation[$this->constants::NAMESPACE_WORD]);

        $message = $this->generator->generateWithImplementation($servicePreparedData);

        $this->setPublishParameter($this->constants::SERVICE_WORD, [
            'file' => $message['file'],
            'name' => $servicePreparedData['name'],
            'location' => $servicePreparedData['location'],
            'namespace' => $this->generator->getNamespace($servicePreparedData),
        ]);

        if ($this->isWithoutRegistrationInProvider()) {
            $this->generateFileMessage($this->constants::SERVICE_WORD, $message);
            return 0;
        }

        $this->checkOrGenerateIt($this->constants::PROVIDER_WORD);
        $this->setPublishImplementation($this->implementation);

        $this->generateFileMessage($this->constants::SERVICE_WORD, $message);

        $this->publisher->configProviderInAppFile();

        $this->publisher->attachDependency();

        return 0;
    }

    protected function isOnlyService(): bool
    {
        return !$this->interface;
    }

    protected function isWithoutRegistrationInProvider(): bool
    {
        return !$this->provider;
    }

    protected function getParameters()
    {
        $this->namespace = $this->laravel->getNamespace();

        $this->serviceLocation = $this->defaultServiceLocation;

        $this->service = $this->getParameter($this->constants::SERVICE_WORD);
        $this->interface = $this->getParameter($this->constants::INTERFACE_WORD);
        $this->provider = $this->getParameter($this->constants::PROVIDER_WORD);
        $this->implementation = $this->getParameter($this->constants::IMPLEMENTATION_WORD);

        $this->askForParameters();
    }

    protected function askForParameters()
    {
        if (!$this->service) {
            $this->service = $this->askForParameter($this->constants::SERVICE_WORD);
        }

        $this->defaultServiceLocation = $this->serviceLocation;

        //if interface is without dir path to get service dir path
        $this->defaultInterfaceLocation = $this->serviceLocation;


        $this->service = Str::camel($this->service);
        $this->service = Str::studly($this->service);

        if (!$this->option('interface')) {
            return;
        }

        if (!$this->interface) {
            $this->interface = $this->askForParameterYorN($this->constants::INTERFACE_WORD);
        }

        if ($this->interface) {
            if (!$this->provider) {
                $this->provider = $this->askForParameterYorN($this->constants::PROVIDER_WORD);
            }
        }
        $this->interface = Str::camel($this->interface);
        $this->provider = Str::camel($this->provider);

        $this->interface = Str::studly($this->interface);
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
