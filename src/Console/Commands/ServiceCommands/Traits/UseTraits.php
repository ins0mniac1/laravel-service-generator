<?php

namespace Ins0mniac\ServiceGenerator\Console\Commands\ServiceCommands\Traits;

trait UseTraits
{
    use PropertiesTrait;
    use MessagesTrait;
    use AskForTrait;
    use GetParameterTrait;
    use GetAndSetParameterAndLocation;
    use PrepareForExecutionTrait;
    use IsParameterNullTrait;
    use GenerateParameterTrait;
    use SetPublishParameterTrait;
    use CheckForFileOrGenerateItTrait;
}
