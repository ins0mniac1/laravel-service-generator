<?php

namespace Ins0mniac\ServiceGenerator\Console\Commands\ServiceCommands\Objects\HelpersTrait;

trait CheckIfLineExistOrCreateItTrait
{
    public function check($location, $file, $line, $replace)
    {
        if (!\Str::contains($file, $line)) {
            $newProviderFile = \Str::replaceArray($this->defaultUsingString(), [$replace], $file);
            $this->file->put($location, $newProviderFile);
            $file = $this->file->get($location);
        }

        return $file;
    }
}
