<?php

namespace Dhii\Modular\Module;

use Psr\Container\ContainerInterface;

/**
 * Interface for a module service extension.
 *
 * For more information, see the documentation for {@link FactoryInterface}.
 *
 * @since [*next-version*]
 *
 * @see   FactoryInterface
 */
interface ExtensionInterface extends ServiceInterface
{
    /**
     * Invokes the extension, creating the new value for the service that is being extended.
     *
     * @since [*next-version*]
     *
     * @param ContainerInterface $c    The service container.
     * @param mixed              $prev The previous or original service value.
     *
     * @return mixed The extended service value.
     */
    public function __invoke(ContainerInterface $c, $prev);
}
