<?php

namespace Ins0mniac\ServiceGenerator\Console\Commands\ServiceCommands\Objects\HelpersTrait;

trait GetFilesTrait
{

    protected function getAppFile(): string
    {
        return $this->file->get(base_path('config\\app.php'));
    }

    protected function getFileByParameter($parameter): string
    {
        return $this->file->get($this->{$parameter . 'Information'}['file']);
    }
}
