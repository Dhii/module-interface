<?php

namespace Dhii\Modular\Module;

use Psr\Container\ContainerInterface;

/**
 * Interface for a factory object.
 *
 * Objects that implement this interface may be used as service factories and returned by service providers,
 * specifically via {@link Interop\Container\ServiceProviderInterface::getFactories()}.
 *
 * Since objects that implement this interface are recognized by PHP as callable values, due to the {@link __invoke()}
 * magic method, consumers of service providers are unaware of the use of such objects. Implementations will be invoked
 * by the service container to create the service instance or value.
 *
 * The primary uses for factory objects is to:
 * 1. Add dependency information to each factory.
 * 2. Allow implementations to make service definitions more readable.
 * 3. Allow implementations to reduce logical repetitions in service definitions.
 *
 * @since [*next-version*]
 */
interface FactoryInterface
{
    /**
     * Retrieves the keys of dependent services.
     *
     * @since [*next-version*]
     *
     * @return string[] A list of strings each representing the key of a service.
     */
    public function getDependencies();

    /**
     * Invokes the factory, creating the service instance or value.
     *
     * @since [*next-version*]
     *
     * @param ContainerInterface $c The service container.
     *
     * @return mixed The created service instance or value.
     */
    public function __invoke(ContainerInterface $c);
}
