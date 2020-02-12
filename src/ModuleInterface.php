<?php

namespace Dhii\Modular\Module;

use Psr\Container\ContainerInterface;

/**
 * Something that represents an application module.
 *
 * @since [*next-version*]
 */
interface ModuleInterface
{
    /**
     * Retrieves the module's service factories.
     *
     * @since [*next-version*]
     *
     * @return FactoryInterface[]
     */
    public function getFactories() : array;

    /**
     * Retrieves the module's service extensions.
     *
     * @since [*next-version*]
     *
     * @return ExtensionInterface[]
     */
    public function getExtensions() : array;

    /**
     * Runs the module.
     *
     * A services container MUST be given to this method, and MUST be able to provide the services provided by the same
     * module using the same keys. The given container instance is NOT guaranteed to be the same instance that is given
     * to other modules. As such, it is strongly advised to assume that it is, and to avoid referencing services from
     * other modules.
     *
     * @since [*next-version*]
     *
     * @param ContainerInterface $c A services container instance.
     */
    public function run(ContainerInterface $c);
}
