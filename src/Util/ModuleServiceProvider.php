<?php

namespace Mecha\Modular\Util;

use Mecha\Modular\ModuleInterface;
use Interop\Container\ServiceProviderInterface;

/**
 * A service provider adapter for modules.
 *
 * This class may be used to adapt modules into service providers, which could be useful when using containers that
 * work with service providers.
 *
 * Example usage:
 *  ```
 *  $module = new MyModule();
 *  $provider = new ModuleServiceProvider($module);
 *
 *  $container = new SpContainer([$provider]);
 *  ```
 *
 * @since [*next-version*]
 */
class ModuleServiceProvider implements ServiceProviderInterface
{
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
     * @param ModuleInterface $module
     */
    public function __construct(ModuleInterface $module)
    {
        $this->module = $module;
    }

    /**
     * @inheritDoc
     */
    public function getFactories()
    {
        return $this->module->getFactories();
    }

    /**
     * @inheritDoc
     */
    public function getExtensions()
    {
        return $this->module->getExtensions();
    }
}
