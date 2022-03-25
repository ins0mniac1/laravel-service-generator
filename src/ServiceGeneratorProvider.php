<?php

namespace Ins0mniac\ServiceGenerator;

use Illuminate\Support\ServiceProvider;
use Ins0mniac\ServiceGenerator\Console\Commands\ServiceCommands\CreateInterface;
use Ins0mniac\ServiceGenerator\Console\Commands\ServiceCommands\CreateProvider;
use Ins0mniac\ServiceGenerator\Console\Commands\ServiceCommands\CreateService;

class ServiceGeneratorProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerCommands();
    }

    /**
     * Register the console commands for the package.
     *
     * @return void
     */
    protected function registerCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                CreateService::class,
                CreateInterface::class,
                CreateProvider::class,
            ]);
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            CreateService::class,
            CreateInterface::class,
            CreateProvider::class,
        ];
    }
}
