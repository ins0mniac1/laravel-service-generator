<p align="center">
    <h1>Laravel Service generator for Laravel applications </h1>
</p>


## Introduction

Service generator provides commands to create services, interfaces and providers and register the dependencies in the dependency container.

With this package, you can generate new files (services, interfaces and providers) only with "artisan" command just as controllers creation. 
It is not necessary to list the provider in app.php file. The process of listing providers in app.php and registering the dependencies in the providers is automated. 

The list of the available commands are shown below:

## Features

- Laravel >= v8.0 are supported;
- Easy setup, no additional configuration;
- Easy to use;
- It's made only to facilitate the work of developers; 
- Free and always be free.

## Official Documentation

 - [Installation](#install);
 - [Commands](#commands):
   - [Service creation](#services):
     - [Plain service](#plain-service);
     - [Service with implementation](#service-with-implementation);
   - [Interface creation](#interfaces);
     - [Interface only](#interface-only);
     - [Generate interface and implement it from service](#implement-interface);
   - [Provider creation](#providers);
       - [Provider only](#provider-only);
       - [Register dependency in new or existing provider](#register-dependency);
 - [Examples of generated files](#examples);
 - [Coming soon](#next-stage);
 - [License](#license).


## Installation
<a href="install"></a>

You can install this package via [Composer](http://getcomposer.org/) by running this command: 

```bash
composer require ins0mniac/service-generator
```

> **NOTE :** The package will automatically register itself.

## Commands
<span class="anchor" id="commands"></span>

### <u>For services creating:</u>
<span class="anchor" id="services"></span>

#### <u>Plain service</u>
<span class="anchor" id="plain-service"></span>

You can generate plain service (php file) with :
```bash
$ php artisan create:service NameOfTheService
```

If you don't specify the name of the service, Laravel will ask you to type it.

```bash
$ php artisan create:service
```

With this command, Laravel will generate new file with all the necessary attributes as namespace, class name, etc. The file will be generated in Services/* directory (based of the name of the service), so if you type service name as `Users/User`, the service file will be located in `Services/Users` with name of `UserService`.

#### <u>Service with implementation</u>
<span class="anchor" id="service-with-implementation"></span>

You can generate service which implements interface:

`class NameOfTheService impements NameOfTheInterface`

```bash
$ php artisan create:service NameOfTheService --interface NameOfTheInterface
```

or just

```bash
$ php artisan create:service --interface
```

If you don't specify name of the service and/or interface, Laravel will ask you for them. 

After you type the interface name, Laravel will ask you if you want to register dependency in the container. If you want to register it, just type `y` and enter the name of the Provider (if provider didn't exists, the command will create new one and publish it in app.php). After entering the provider name, you should specify the type of the registering - bind or singleton.

> **NOTE :** This command will create new service file, so if you shouldn't type name of the existing file!

In the end of the generation process you will have:

- New Service class (new file);
- Service class that implements new or existing Interface;
- Registered dependency in new or existing Provider;

### <u>For interfaces creating:</u>
<span class="anchor" id="interfaces"></span>

#### <u>Interface only</u>
<span class="anchor" id="interface-only"></span>


You can generate only interface (php file) with :
```bash
$ php artisan create:interface NameOfTheInterface
```

If you don't specify the name of the interface, Laravel will ask you to type it.

```bash
$ php artisan create:interface
```

#### <u>Generate interface and implement it from new or existing service</u>
<span class="anchor" id="implement-interface"></span>

You can generate interface and implement it:

`class NameOfTheService impements NameOfTheInterface`

```bash
$ php artisan create:interface NameOfTheInterface --service NameOfTheService
```

or just

```bash
$ php artisan create:interface --service
```

If you don't specify name of the interface and/or service, Laravel will ask you for them.

After you type the interface name, Laravel will ask you if you want to register dependency in the container. If you want to register it, just type `y` and enter the name of the Provider (if provider didn't exists, the command will create new one and publish it in app.php). After entering the provider name, you should specify the type of the registering - bind or singleton.

In the end of the generation process you will have:

- Service class that implements new or existing Interface;
- Registered dependency in new or existing Provider;

### <u>For provider creating:</u>
<span class="anchor" id="providers"></span>

#### <u>Provider only</u>
<span class="anchor" id="provider-only"></span>

You can generate only provider (php file) with :
```bash
$ php artisan create:provider NameOfTheProvider
```

If you don't specify the name of the provider, Laravel will ask you to type it.

```bash
$ php artisan create:provider
```

#### <u>Generate or get existing provider and register dependency in it</u>
<span class="anchor" id="register-dependency"></span>

You can generate or get existing provider:

```bash
$ php artisan create:provider NameOfTheProvider --register
```

or just

```bash
$ php artisan create:provider --register
```

If you don't specify name, Laravel will ask you for them.

After you type the provider name, Laravel will ask you for the names of service and interface and the type of the registering - bind or singleton.

In the end of the generation process you will have:

- Service class that implements new or existing Interface;
- Registered dependency in new or existing Provider;

## Examples of generated files
<span class="anchor" id="examples"></span>

- [Plain service](_documentation/PLAINSERVICE.md);
- [Services with implementation](_documentation/SERVICEIMPEMENTS.md);
- [Interface](_documentation/INTERFACE.md);
- [Provider](_documentation/PROVIDER.md);
- [Changes in app.php](_documentation/APPPHP.md);

## Coming soon
<span class="anchor" id="next-stage"></span>

The next stage will be adding --resource option to create:service and create:interface commands. This will allow you to generate files with resource methods - getAll(), findByKey(Model $model), etc.

## License
<span class="anchor" id="license"></span>

Laravel Service Generator is open-sourced software licensed under the [MIT license](_documentation/LICENSE.md).
