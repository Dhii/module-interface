<?php

namespace Dhii\Modular\Module;

use Dhii\Data\KeyAwareInterface;
use Psr\Container\ContainerInterface;

/**
 * Anything that represents a system module.
 *
 * A module is represented by an key, which is not limited to any type or form. It can be numeric, a slug, a hash or
 * even a user-friendly name. What matters is that it **uniquely** identifies the module.
 *
 * @since [*next-version*]
 */
interface ModuleInterface extends KeyAwareInterface
{
    /**
     * Performs module-specific setup and optionally provides a container.
     *
     * This method should be invoked when the application is setting up the modules in the early stages of
     * initialization. Therefore, this method can safely assume that _some_ other modules have been `setup()`, but
     * _none_ of them have been `run()`. If required, the module can return services in a container, for consumption
     * by the application. However, this is depends on the application, and as such there is no guarantee that the
     * container will actually be utilized.
     *
     * @since [*next-version*]
     *
     * @return ContainerInterface|null A container instance, if any.
     */
    public function setup();

    /**
     * Runs the module.
     *
     * This method should be invoked when the application has been initialized and all modules have been set up.
     * Therefore, this method can safely assume that _all_ other modules have been `setup()`, but _not all_ of them have
     * been `run()`. Additionally, the container given to this method is not necessarily the same container returned
     * by the instance's `setup()` method. In fact, it is strongly advised to not assume so.
     *
     * @since [*next-version*]
     *
     * @param ContainerInterface|null $c Optional DI container instance.
     */
    public function run(ContainerInterface $c = null);
}
