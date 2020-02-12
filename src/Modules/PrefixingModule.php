<?php

namespace Mecha\Modular\Modules;

use Dhii\Container\DeprefixingContainer;
use Mecha\Modular\ModuleInterface;
use Mecha\Modular\ServiceInterface;
use Psr\Container\ContainerInterface;

/**
 * A module decorator that can prefix another module's services.
 *
 * When a module is decorated with an instance of this class, the module's factories and extensions will have a
 * prefix applied to them. Furthermore, each service will be modified such that its dependency keys are also prefixed,
 * if they refer to one of the module's services. References to services outside the module are unaffected.
 *
 * The module the run, the original module is given a decorated container that will automatically attempt to add the
 * prefix. This lets the original module use its original service keys internally, while externally (at an application
 * level) its service keys remain prefixed.
 *
 * Example usage:
 *  ```
 *  new PrefixingModule('log/', new LoggingModule());
 *
 *  class LoggingModule implements ModuleInterface {
 *      public function getFactories() : array {
 *          return [
 *              'level' => new Value(LogLevel::ERROR),
 *
 *              'logger' => new Factory(['level'], ...),
 *          ];
 *      }
 *
 *      public function getExtensions() : array {
 *          return [];
 *      }
 *
 *      public function run(ContainerInterface $c) {
 *          $c->get('logger'); // works!
 *
 *          $logger->log('Logger loaded');
 *      }
 *  }
 *
 *  // In another module or at an application level:
 *  $c->get('log/logger'); // returns the logger
 *  $c->get('logger');     // not found!
 *  ```
 *
 * @since [*next-version*]
 */
class PrefixingModule implements ModuleInterface
{
    /**
     * @since [*next-version*]
     *
     * @var string
     */
    protected $prefix;

    /**
     * @since [*next-version*]
     *
     * @var ModuleInterface
     */
    protected $module;

    /**
     * Constructor.
     *
     * @since [*next-version*]
     *
     * @param string          $prefix The prefix to apply to the module's services.
     * @param ModuleInterface $module The module instance to prefix.
     */
    public function __construct(string $prefix, ModuleInterface $module)
    {
        $this->prefix = $prefix;
        $this->module = $module;
    }

    /**
     * @inheritDoc
     */
    public function getFactories() : array
    {
        return $this->prefixServices($this->module->getFactories());
    }

    /**
     * @inheritDoc
     */
    public function getExtensions() : array
    {
        return $this->prefixServices($this->module->getExtensions());
    }

    /**
     * @inheritDoc
     */
    public function run(ContainerInterface $c)
    {
        $this->module->run(new DeprefixingContainer($c, $this->prefix, false));
    }

    /**
     * Prefixes a list of services.
     *
     * @since [*next-version*]
     *
     * @param ServiceInterface[] $services The services to prefix.
     *
     * @return array The list of prefixed services.
     */
    protected function prefixServices(array $services)
    {
        $results = [];

        foreach ($services as $key => $service) {
            $newKey = $this->prefix . $key;

            $dependencies = $service->getDependencies();
            $dependencies = array_map(function ($dep) use ($services) {
                // Only prefix dependencies that exist as services inside the module
                return array_key_exists($dep, $services)
                    ? $this->prefix . $dep
                    : $dep;
            }, $dependencies);

            $results[$newKey] = $service->withDependencies($dependencies);
        }

        return $results;
    }
}
