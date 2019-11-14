<?php

namespace Dhii\Modular\Module\Factories;

use Psr\Container\ContainerInterface;

/**
 * A factory implementation that returns a callback.
 *
 * The callback is passed the service instances that correspond with its dependency keys, in the order they are given.
 * These service instances are fetched only once when the callback is created, and are then cached in the returned
 * callback's scope.
 *
 * @since [*next-version*]
 */
class Callback extends AbstractFactory
{
    /**
     * @since [*next-version*]
     *
     * @var callable
     */
    protected $callback;

    /**
     * Constructor.
     *
     * @since [*next-version*]
     *
     * @param string[] $dependencies The keys of dependent services.
     * @param callable $callback     The callback to return for this service.
     */
    public function __construct(array $dependencies, callable $callback)
    {
        parent::__construct($dependencies);

        $this->callback = $callback;
    }

    /**
     * @inheritdoc
     *
     * @since [*next-version*]
     */
    public function __invoke(ContainerInterface $c)
    {
        $deps = array_map([$c, 'get'], $this->dependencies);

        return function () use ($deps) {
            return call_user_func_array($this->callback, $deps);
        };
    }
}
