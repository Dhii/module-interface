<?php

namespace Mecha\Modular\Services;

use Mecha\Modular\ServiceInterface;
use Psr\Container\ContainerInterface;

/**
 * A partial implementation of a service, that is aware of a list of dependency keys.
 *
 * @since [*next-version*]
 */
abstract class AbstractService implements ServiceInterface
{
    /**
     * @since [*next-version*]
     *
     * @var string[]
     */
    protected $dependencies;

    /**
     * Constructor.
     *
     * @since [*next-version*]
     *
     * @param string[] $dependencies The keys of dependent services.
     */
    public function __construct(array $dependencies)
    {
        $this->dependencies = $dependencies;
    }

    /**
     * @inheritdoc
     *
     * @since [*next-version*]
     */
    public function getDependencies() : array
    {
        return $this->dependencies;
    }

    /**
     * @inheritDoc
     *
     * @since [*next-version*]
     */
    public function withDependencies(array $dependencies) : ServiceInterface
    {
        $clone = clone $this;
        $clone->dependencies = $dependencies;

        return $clone;
    }

    /**
     * Resolves the dependency keys to their corresponding values from a container.
     *
     * @since [*next-version*]
     *
     * @param ContainerInterface $c The container from which to resolve service values.
     *
     * @return array An array of service values, in the same order as in {@link AbstractService::$dependencies}.
     */
    protected function resolveDependencies(ContainerInterface $c) : array
    {
        return array_map([$c, 'get'], $this->dependencies);
    }
}
