<?php

namespace Dhii\Modular\Module;

use Dhii\Modular\Module\Exception\ModuleRunException;
use Dhii\Modular\Module\Exception\ModuleSetupException;
use Interop\Container\ServiceProviderInterface;
use Psr\Container\ContainerInterface;

/**
 * Something that represents an application module.
 *
 * @since [*next-version*]
 */
interface ModuleInterface
{
    /**
     * Performs module-specific setup and provides a service provider.
     *
     * This method SHOULD be called at least once before {@link ModuleInterface::run()} may be invoked for a particular
     * module instance. The returned service provider instance SHOULD be incorporated by the application into the
     * container instance that is then given to this module's {@link ModuleInterface::run()} method.
     *
     * The application MAY also incorporate the service provider into the container instance given to other modules,
     * but this is not required. As such, services factories in the returned service provider should not assume the
     * existence of other module's services. Use proxy services together with {@link ContainerInterface::has()} for
     * optionally integrating with other modules.
     *
     * @since [*next-version*]
     *
     * @return ServiceProviderInterface A service provider instance for this module's services.
     *
     * @throws ModuleSetupException If module setup failed and/or a service provider instance could not be returned.
     */
    public function setup() : ServiceProviderInterface;

    /**
     * Runs the module.
     *
     * This method MUST be called after the module has been set up using {@link ModuleInterface::setup()}. A services
     * container MUST be given to this method, and MUST incorporate the services from the service provider returned
     * by the same module's {@link ModuleInterface::setup()} method. This container instance is not guaranteed to be
     * the same instance given to other modules. As such, it is strongly advised to assume it is not, and to avoid
     * referencing services from other modules.
     *
     * @since [*next-version*]
     *
     * @param ContainerInterface $c A services container instance.
     *
     * @throws ModuleRunException If the module failed to run.
     */
    public function run(ContainerInterface $c);
}
