<?php

namespace Ins0mniac\ServiceGenerator\Console\Commands\ServiceCommands\Traits;

use Illuminate\Support\Str;

trait AskForTrait
{
    protected function askForParameter($parameter): string
    {
        $answer = $this->ask('Enter name of the ' . $parameter);

        if (is_numeric($answer)) {
            $answer = $this->askForValidParameter($parameter);
        }

        if ($parameter === $this->constants::IMPLEMENTATION_WORD) {
            return $answer;
        }

        return Str::ucfirst($this->getParameterAndSetLocation($parameter, $answer));
    }

    protected function askForParameterYorN($parameter): ?string
    {
        $question = $this->ask('Do you want to create/attach ' . $parameter . ' [Y/N]');


        if ($question === 'N' || $question === 'n') {
            return null;
        }

        if ($question !== 'Y' && $question !== 'y') {
            return $this->askForParameterYorN($parameter);
        }

        $answer = $this->ask('Enter the name of the ' . $parameter);

        if (is_numeric($answer)) {
            $answer = $this->askForValidParameter($parameter);
        }

        return Str::ucfirst($this->getParameterAndSetLocation($parameter, $answer));
    }

    protected function askForValidParameter($parameter)
    {
        $answer = $this->ask('Enter a valid ' . $parameter . ' name!');
        if (is_numeric($answer)) {
            return $this->askForValidParameter($parameter);
        }

        return $answer;
    }

    protected function askForImplementation()
    {
        $answer = $this->ask('Choose the implementation type (can be only bind or singleton)');

        if (is_numeric($answer)) {
            $answer = $this->askForImplementation();
        }

        if (Str::lower($answer) !== 'bind' && Str::lower($answer) !== 'singleton') {
            $answer = $this->askForImplementation();
        }

        return Str::ucfirst($answer);
    }
}
