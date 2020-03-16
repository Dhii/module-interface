# Dhii - Module Interface

[![Build Status](https://travis-ci.org/Dhii/module-interface.svg?branch=develop)](https://travis-ci.org/Dhii/module-interface)
[![Code Climate](https://codeclimate.com/github/Dhii/module-interface/badges/gpa.svg)](https://codeclimate.com/github/Dhii/module-interface)
[![Test Coverage](https://codeclimate.com/github/Dhii/module-interface/badges/coverage.svg)](https://codeclimate.com/github/Dhii/module-interface/coverage)
[![Latest Stable Version](https://poser.pugx.org/dhii/module-interface/version)](https://packagist.org/packages/dhii/module-interface)

## Details
This package contains interfaces that are useful in describing modules and their attributes and behaviour.
 
### Requirements
- PHP: 7.1 and up, until 8.

    Officially supports at least up to php 7.4.x.

### Interfaces
- [`ModuleInterface`][] - The interface for a module. A module is an object that represents an
application fragment. Modules are prepared using `setup()`, which returns a `ServiceProviderInterface` instance that
the application may consume, and invoked using `run()`, consuming the application's DI container.
- [`ModuleAwareInterface`][] - Something that can have a module retrieved.
- [`ModuleExceptionInterface`][] - An exception thrown by a module.

### Usage
#### Module Package
In your module's pacakge, create a file that returns a module factory. This factory MUST return an instance
of `ModuleInterface` from this pacakge. By convention, this file has
the name `module.php`, and is located in the root directory. Below is a very basic example. In real life,
the service provider and the module will often have named classes of their own, and factories and extensions
will be located in `services.php` and `extensions.php` respectively, by convention.

```php
// module.php
use Dhii\Modular\Module\ModuleInterface;
use Interop\Container\ServiceProviderInterface;
use Psr\Container\ContainerInterface;

return function () {
    return new class () implements ModuleInterface {
    
        /**
         * Declares services of this module.
         * 
         * @return ServiceProviderInterface The service provider with the factories and extensions of this module.
         */
        public function setup() : ServiceProviderInterface
        {
            return new class () implements ServiceProviderInterface
            {
                /**
                 * Only the factory of the last module in load order is applied. 
                 * 
                 * @return array|callable[] A map of service names to service definitions.
                 */
                public function getFactories()
                {
                    return [
                        // A factory always gets one parameter: the container.
                        'my_module/my_service' => function (ContainerInterface $c) {
                            // Create and return your service instance
                            return new MyService(); 
                        },
                    ];
                }
                
                /**
                 * All extensions are always applied, in load order. 
                 * 
                 * @return array|callable[] A map of service names to extensions.
                 */            
                public function getExtensions()
                {
                    return [
                        // An extension gets an additional parameter:
                        // the value returned by the factory or the previously applied extensions.
                        'other_module/other_service' => function (
                            ContainerInterface $c,
                            OtherServiceInterface $previous
                        ): OtherServiceInterface {
                            // Perhaps decorate $previous and return the decorator
                            return new MyDecorator($previous);
                        },
                    ];
                }
            };    
        }

        /**
         * Consumes services of this and other modules.
         * 
         * @param ContainerInterface $c A container with the services of all modules.
         */
        public function run(ContainerInterface $c)
        {
            $myService = $c->get('my_module/my_service');
            $myService->doSomething();
        }       
    };
};
```

In the above example, the module declares a service `my_module/my_service`, and an extension
for the `other_module/other_service`, which may be found in another module. Note that by convention,
the service name contains the module name prefix, separated by forward slash `/`. It's possible
to further "nest" services by adding slash-separated "levels". In the future, some container
implementations will add benefits for modules that use this convention.

Applications would often need the ability to do something with the arbitrary set of
modules they require. In order for an application to be able to group all modules
together, declare the package type in your `composer.json` to be `dhii-mod` by convention.
Following this convention would allow all modules written by all authors to be treated
uniformly.

```json
{
    "name": "me/my_module",
    "type": "dhii-mod"
}
```

What's important here:

1. A module's `setup()` method should not cause side effects.

    The setup method is intended for the modules to prepare for action. Modules should not actually
    peform the actions during this method. The container is not available in this method, and therefore
    the module cannot use any services, whether of itself or of other modules, in this method. Do not
    try to make the module use its own services here.
    
2. Implement the correct interfaces.

    A module MUST implement `ModuleInterface`. The module's `setup()` method MUST return `ServiceProviderInterface`.
    Even though the [Service Provider][`container-interop/service-provider`] standard is experimental, and has been experimental for a long time, the
    module standard relies heavily on it. If the module standard becomes ubiquitous, this could push
    FIG to go forward with the Service Provider standard, hopefully making it into a PSR.
    
3. Observe conventions.

    It is important that conventions outlined here are observed. Some are necessary for smooth operation of
    modules and/or consuming applications. Some others may not make a difference right now, but could
    add benefits in the future. Please observe these conventions to ensure an optimal experience
    for yourself and for other users of the standard.

#### Consumer Package
##### Module Installation
The package that consumes modules, which is usually the application, would need to require the modules.
The below example uses the [`oomphinc/composer-installers-extender`][] lib to configure Composer
so that it installs all `dhii-mod` packages into the `modules` directory in the application root.
Packages `me/my_module` and `me/my_other_module` would therefore go into `modules/me/my_module` and
`modules/me/my_other_module` respectively.

```json
{
  "name": "me/my_app",
  "require": {
    "me/my_module": "^0.1",
    "me/my_other_module": "^0.1",
    "oomphinc/composer-installers-extender": "^1.1"
  },
  
  "extra": {
    "installer-types": ["dhii-mod"],
    "installer-paths": {
      "modules/{$vendor}/{$name}": ["type:dhii-mod"]
    }
  }
}
```  

##### Module Loading
Once a module has been required, it must be loaded. Module files must be explicitly loaded by the
application, because the application is what determines module load order. The load order is
the fundamental principle that allows modules to extend and override each other's services
in a simple and intuitive way:

1. Factories in modules that are loaded later will completely override factories of modules loaded earlier.

    Ultimately, for each service, only one factory will be used: the one declared last. So if `my_other_module`
    is loaded after `my_module`, and it declares a service `my_module/my_service`,
    then it will override the `my_module/my_service` service declared by `my_module`.
    In short: **last factory wins**.
    
2. Extensions in modules that are loaded later will be applied after extensions of modules loaded earlier.

    Ultimately, extensions from _all_ modules will be applied on top of what is returned by the factory.
    So if `my_other_module` declares an extension `other_module/other_service`, it will be applied after
    the extension `other_module/other_service` declared by `my_module`.
    In short: **later extensions extend previous extensions**.
    
Continuing from the examples above, if something in the application requests the service `other_module/other_service`
declared by `my_other_module`, this is what is going to happen:

1. The factory in `my_other_module` is invoked.
2. The extension in `my_module` is invoked, and receives the result of the above factory as `$previous`.
3. The extension in `my_other_module` is invoked, and receives the result of the above extension as `$previous`
4. The caller of `get('other_module/other_service')` receives the result of the above extension.

Thus, any module can override and/or extend services from any other module. Below is an example of what
an application's bootstrap code could look like. This example uses classes from [`dhii/containers`][].

```php
// bootstrap.php

use Dhii\Modular\Module\ModuleInterface;
use Interop\Container\ServiceProviderInterface;
use Dhii\Container\CompositeCachingServiceProvider;
use Dhii\Container\DelegatingContainer;
use Dhii\Container\CachingContainer;

(function ($file) {
    $baseDir = dirname($file);
    $modulesDir = "$baseDir/modules";
    
    // Order is important!
    $moduleNames = [
        'me/my_module',
        'me/my_other_module',
    ];
    
    // Create and load all modules
    /* @var $modules ModuleInterface[] */
    $modules = [];
    foreach ($moduleNames as $moduleName) {
        $moduleFactory = require_once("$modulesDir/$moduleName/module.php");
        $module = $moduleFactory();
        $modules[$moduleName] = $module;
    }

    // Retrieve all modules' service providers
    /* @var $providers ServiceProviderInterface[] */
    $providers = [];
    foreach ($modules as $module) {
        $providers[] = $module->setup();
    }
    
    // Group all service providers into one
    $provider = new CompositeCachingServiceProvider();
    $container = new CachingContainer(new DelegatingContainer($provider, $parentContainer = null));

    // Run all modules
    foreach ($modules as $module) {
        $module->run($container);
    }
})(__FILE__);
```

The above will load, setup, and run modules `me/my_module` and `me/my_other_module`, in that order,
from the `modules` directory, provided that conventions have been followed by those modules.
What's important to note here:

1. First _all_ modules are set up, and then _all_ modules are run.

    If you set up and run modules in the same step, it will not work, because the bootstrap
    will not have the opportunity to configure the application's DI container with services
    from all modules.
    
2. The `CompositeCachingServiceProvider` is what is responsible for resolving services correctly.
    
    This relieves the application, as the process can seem complicated, and is quite re-usable.
    The usage of this class is recommended.
    
3. The `DelegatingContainer` optionally accepts a parent container.

    If your application is a module itself, and needs to be part of a larger application with its
    own DI container, supply it as the 2nd parameter. This will ensure that services will always
    be retrieved from the top-most container, regardless of where the definition is declared.
    
4. The `CachingContainer` ensures services are cached.

    Effectively, this means that all services are singletons, i.e. there will only be one instance
    of each service in the application. This is most commonly the desired behaviour. Without the
    `CachingContainer`, i.e. with just the `DelegatingContainer`, service definitions will get
    invoked every time `get()` is called, which is usually undesirable.
    
5. Conventions are important.

    If modules did not place the `module.php` file into their root directories, the bootstrap
    would not be able to load each module by just its package name. Modules which do not
    follow that convention must have their `module.php` file loaded separately, which would
    make the bootstrap code more complicated. 


[Dhii]: https://github.com/Dhii/dhii

[`dhii/containers`]: https://packagist.org/packages/dhii/containers
[`oomphinc/composer-installers-extender`]: https://packagist.org/packages/oomphinc/composer-installers-extender
[`container-interop/service-provider`]: https://packagist.org/packages/container-interop/service-provider

[`ModuleInterface`]:                src/ModuleInterface.php
[`ModuleAwareInterface`]:           src/ModuleAwareInterface.php
[`ModuleExceptionInterface`]:       src/Exception/ModuleExceptionInterface.php
