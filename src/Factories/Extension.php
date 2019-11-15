<?php

namespace Dhii\Modular\Module\Factories;

use Psr\Container\ContainerInterface;

class Extension extends AbstractFactory
{
    /**
     * @since [*next-version*]
     *
     * @var callable
     */
    protected $factoryFn;

    /**
     * Constructor.
     *
     * @since [*next-version*]
     *
     * @param string[] $dependencies The keys of dependent services.
     * @param callable $factoryFn    The factory function that creates the service instance. Receives the previous
     *                               service instance as the first argument and any dependent service instances as
     *                               subsequent arguments, in the order they are given in $dependencies.
     */
    public function __construct(array $dependencies, callable $factoryFn)
    {
        parent::__construct($dependencies);

        $this->factoryFn = $factoryFn;
    }

    /**
     * @inheritdoc
     *
     * @since [*next-version*]
     */
    public function __invoke(ContainerInterface $c, $prev = null)
    {
        $deps = array_map([$c, 'get'], $this->dependencies);
        $args = array_merge([$prev], $deps);

        return call_user_func_array($this->factoryFn, $args);
    }
}
