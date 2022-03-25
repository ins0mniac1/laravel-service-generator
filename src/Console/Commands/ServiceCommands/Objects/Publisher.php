<?php

namespace Ins0mniac\ServiceGenerator\Console\Commands\ServiceCommands\Objects;

use Ins0mniac\ServiceGenerator\Console\Commands\ServiceCommands\Objects\HelpersTrait\UseHelpersTrait;
use Illuminate\Contracts\Foundation\CachesConfiguration;
use Illuminate\Filesystem\Filesystem;

class Publisher
{
    use UseHelpersTrait;

    const CLASS_EXTENSION = '::class';
    const CLASS_EXTENSION_WITH_COMMA = '::class,';

    const MAPPER = [
        'bind' => '$bindings',
        'singleton' => '$singletons',
    ];

    private Filesystem $file;
    private string $searchFor;
    private string $appFile;

    public function __construct()
    {
        $this->file = new Filesystem();

        $this->searchFor = $this->searchingString();

        $this->appFile = $this->getAppFile();
    }

    public function configProviderInAppFile()
    {
        if (!(app() instanceof CachesConfiguration && app()->configurationIsCached())) {
            $config = app()->make('config');

            $existingProviders = $config->get('app.providers', []);

            $appFile = $this->appFile;

            $newProviderLine = $this->providerInformation['namespace'] . '\\' . $this->providerInformation['name'] . self::CLASS_EXTENSION_WITH_COMMA;

            if (\Str::contains($appFile, $newProviderLine)) {
                return;
            }

            $lastExistingProvider = end($existingProviders) . self::CLASS_EXTENSION_WITH_COMMA;

            $defaultComment = <<<END
        $this->searchFor
END;

            if (!\Str::contains($appFile, $this->searchFor)) {
                $replace = $lastExistingProvider . PHP_EOL . $defaultComment . PHP_EOL;
                $newAppFile = \Str::replaceArray($lastExistingProvider, [$replace], $appFile);
                $this->file->put(base_path('config\\app.php'), $newAppFile);

                $appFile = $this->getAppFile();
            }


            $newProviderLine = <<<END
        $newProviderLine
END;

            $nextReplace = $defaultComment . PHP_EOL . $newProviderLine;

            $newAppFile = \Str::replaceArray($defaultComment, [$nextReplace], $appFile);

            $this->file->put(base_path('config\\app.php'), $newAppFile);
        }
    }

    public function attachDependency()
    {
        $providerLocation = $this->providerInformation['file'];
        $providerFile = $this->file->get($providerLocation);

        $defaultComment = $this->{'searching' . \Str::ucfirst($this->implementation) . 'String'}();


        $interfaceToService = $this->interfaceInformation['name'] . $this::CLASS_EXTENSION
            . ' => '
            . $this->serviceInformation['name'] . $this::CLASS_EXTENSION_WITH_COMMA;

        $dependency = <<<END
        $interfaceToService
END;

        $interface = $this->interfaceInformation['namespace'] . '\\' . $this->interfaceInformation['name'];
        $service = $this->serviceInformation['namespace'] . '\\' . $this->serviceInformation['name'];

        $interfaceNamespace = 'use ' . $interface . ';' . PHP_EOL . $this->defaultUsingString();
        $serviceNamespace = 'use ' . $service . ';' . PHP_EOL . $this->defaultUsingString();

        if (\Str::contains($providerFile, $interfaceToService)) {
            return;
        }

        $providerFile = $this->check($providerLocation, $providerFile, $interface, $interfaceNamespace);
        $providerFile = $this->check($providerLocation, $providerFile, $service, $serviceNamespace);

        if (!\Str::contains($providerFile, $defaultComment)) {
            $arrayBeginning = $this::MAPPER[$this->implementation] . ' = [';

            $replace = $arrayBeginning . PHP_EOL . $defaultComment;
            $newProviderFile = \Str::replaceArray($arrayBeginning, [$replace], $providerFile);
            $this->file->put($providerLocation, $newProviderFile);
            $providerFile = $this->file->get($providerLocation);
        }

        $replace = $defaultComment . PHP_EOL . $dependency;

        $newProviderFile = \Str::replaceArray($defaultComment, [$replace], $providerFile);
        $this->file->put($providerLocation, $newProviderFile);
    }
}
