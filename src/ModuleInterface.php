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
     * This method SHOULD be used to allow the module to set up and prepare itself for invocation.
     * If required, the module MAY provide services in a container. However, the usage of this container is dependent on
     * the consumer and as such there is no guarantee that the container will actually be utilized.
     *
     * @since [*next-version*]
     *
     * @return ContainerInterface|null A DI container instance, if any.
     */
    public function setup();

    /**
     * Runs the module.
     *
     * This method MUST be called when the module has been set up and is ready for invocation.
     * A service container MAY be given to this method, which MAY consume its services. This container is not
     * necessarily the same container returned by the instance's `setup()` method. In fact, it is strongly advised to
     * assume that this is not the case.
     *
     * @since [*next-version*]
     *
     * @param ContainerInterface|null $c Optional DI container instance.
     */
    public function run(ContainerInterface $c = null);
}
