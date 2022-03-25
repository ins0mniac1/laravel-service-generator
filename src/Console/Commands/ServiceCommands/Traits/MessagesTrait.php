<?php

namespace Ins0mniac\ServiceGenerator\Console\Commands\ServiceCommands\Traits;

trait MessagesTrait
{
    public function generateFileMessage($param, $message)
    {
        return $this->{$message['status'] . 'GeneratedFile'}($param, $message);
    }

    public function successGeneratedFile($param, $message)
    {
        return $this->info('Great! The new ' . $param . ' is created! You can check it here: ' . $message['message']);
    }

    public function alertGeneratedFile($param, $message)
    {
        return $this->info('Oops! The ' . $param . ' ' . $message['message']);
    }
}
