<?php

namespace Mecha\Modular;

use Psr\Container\ContainerInterface;

/**
 * Interface for a module service factory.
 *
 * Services can be obtained from the factory through invocation, which is made possible by the {@link __invoke()} magic
 * PHP method. The reasoning for this is to make objects that implement this interface also be compatible with DI
 * container service factories (or "definitions", as they are sometimes referred to).
 *
 * This interface may be freely implemented to craft specific types of factories, especially reusable ones. This can
 * help make long lists of factories more legible as well as help to reduce repeated construction logic.
 *
 * @since [*next-version*]
 */
interface FactoryInterface extends ServiceInterface
{
    /**
     * Invokes the factory, creating the service instance or value.
     *
     * @since [*next-version*]
     *
     * @param ContainerInterface $c The service container.
     *
     * @return mixed The created service value.
     */
    public function __invoke(ContainerInterface $c);
}
