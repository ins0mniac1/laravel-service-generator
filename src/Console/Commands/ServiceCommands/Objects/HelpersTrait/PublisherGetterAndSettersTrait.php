<?php

namespace Ins0mniac\ServiceGenerator\Console\Commands\ServiceCommands\Objects\HelpersTrait;

trait PublisherGetterAndSettersTrait
{
    protected array $serviceInformation = [
        'file' => '',
        'name' => '',
        'location' => '',
        'namespace' => '',
    ];

    protected array $interfaceInformation = [
        'file' => '',
        'name' => '',
        'location' => '',
        'namespace' => '',
    ];

    protected array $providerInformation = [
        'file' => '',
        'name' => '',
        'location' => '',
        'namespace' => '',
    ];

    protected ?string $implementation;


    /**
     * @return array|string[]
     */
    public function getServiceInformation(): array
    {
        return $this->serviceInformation;
    }

    /**
     * @param array|string[] $serviceInformation
     */
    public function setServiceInformation(array $serviceInformation): void
    {
        $this->serviceInformation = $serviceInformation;
    }

    /**
     * @return array|string[]
     */
    public function getInterfaceInformation(): array
    {
        return $this->interfaceInformation;
    }

    /**
     * @param array|string[] $interfaceInformation
     */
    public function setInterfaceInformation(array $interfaceInformation): void
    {
        $this->interfaceInformation = $interfaceInformation;
    }

    /**
     * @return array|string[]
     */
    public function getProviderInformation(): array
    {
        return $this->providerInformation;
    }

    /**
     * @param array|string[] $providerInformation
     */
    public function setProviderInformation(array $providerInformation): void
    {
        $this->providerInformation = $providerInformation;
    }

    /**
     * @return ?string
     */
    public function getImplementation(): string
    {
        return $this->implementation;
    }

    /**
     * @param string $implementation
     */
    public function setImplementation(string $implementation): void
    {
        $this->implementation = $implementation;
    }
}
