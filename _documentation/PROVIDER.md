## Example of generated Provider
<br />

```php
<?php

namespace App\Namespace;

//by default namespace will be App\Providers 

use Illuminate\Support\ServiceProvider;

class NameOfTheProvider extends ServiceProvider
{

    /**
     * All of the container bindings that should be registered.
     *
     * @var array
     */
    public $bindings = [
        /*
         * All Bindings dependencies
         */
    ];

    /**
     * All of the container singletons that should be registered.
     *
     * @var array
     */
    public $singletons = [
        /*
         * All Singletons dependencies
         */
    ];

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
        //
    }
}


```
