<?php

namespace Ins0mniac\ServiceGenerator\Console\Commands\ServiceCommands\Objects;

use Illuminate\Filesystem\Filesystem;

class Generator
{
    private Filesystem $file;

    public function __construct()
    {
        $this->file = new Filesystem();
    }

    public function generatePlain(array $data): array
    {
        $preparedData = $this->prepareData($data, 'plain');

        $replacedFile = $this->replace($preparedData['fileOriginalString'], 'namespace', $preparedData['namespace']);
        $replacedFile = $this->replace($replacedFile, 'class', $data['name']);

        if ($this->check($preparedData['destination'])) {
            return [
                'status' => 'alert',
                'message' => 'Already exists!',
                'file' => $preparedData['destination'],
            ];
        }

        $this->file->put($preparedData['destination'], $replacedFile);

        return [
            'status' => 'success',
            'message' => $preparedData['destination'],
            'file' => $preparedData['destination'],
        ];
    }

    public function generateWithImplementation($data): array
    {
        $preparedData = $this->prepareData($data, 'implementation');

        $replacedFile = $this->replace($preparedData['fileOriginalString'], 'namespace', $preparedData['namespace']);
        $replacedFile = $this->replace($replacedFile, 'class', $data['name']);
        $replacedFile = $this->replace($replacedFile, 'implementation', $data['implementation']);

        $implementationNamespace = '';

        if ($preparedData['namespace'] !== $data['implementationNamespace']) {
            $implementationNamespace = 'use ' . $data['implementationNamespace'] . '\\' . $data['implementation'] . ';';
        }

        $replacedFile = $this->replace($replacedFile, 'use', $implementationNamespace);


        if ($this->check($preparedData['destination'])) {
            return [
                'status' => 'alert',
                'message' => 'Already exists!',
                'file' => $preparedData['destination'],
            ];
        }

        $this->file->put($preparedData['destination'], $replacedFile);

        return [
            'status' => 'success',
            'message' => $preparedData['destination'],
            'file' => $preparedData['destination'],
        ];
    }

    public function prepareData($data, $documentType = 'plain'): array
    {
        $fileOrigin = base_path('vendor\\ins0mniac\\service-generator\\stubs\\' . \Str::lower($data['type']) . '.' . \Str::lower($documentType) . '.stub');

        $fileOriginalString = $this->file->get($fileOrigin);

        $this->makeAllFolders($data['location']);

        return [
            'fileOrigin' => $fileOrigin,
            'fileOriginalString' => $fileOriginalString,
            'destination' => base_path('app\\' . $data['location'] . '\\' . $data['name'] . '.php'),
            'namespace' => $this->getNamespace($data)
        ];
    }

    public function getNamespace($data): string
    {
        $namespace = $data['namespace'] . $data['location'];

        return \Str::replace('/', '\\', $namespace);
    }

    public function check($destination): bool
    {
        return $this->file->isFile($destination);
    }

    protected function makeAllFolders($path)
    {
        $folders = explode('\\', $path);
        $destination = 'app\\';
        $this->createDirectory($destination, $folders);
    }

    protected function createDirectory($destination, array $folders)
    {
        for ($index = 0; $index < count($folders); $index++) {
            $destination .= '\\' . $folders[$index];
            if (!$this->file->isDirectory($destination)) {
                $this->file->makeDirectory($destination);
            }
        }
    }

    protected function replace($file, $replacement, $value)
    {
        return \Str::replaceArray('{{ ' . $replacement . ' }}', [$value], $file);
    }
}
