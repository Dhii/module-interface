<?php

namespace Dhii\Modular\Module\Services;

use Dhii\Modular\Module\ExtensionInterface;
use Psr\Container\ContainerInterface;

class Extension extends AbstractService implements ExtensionInterface
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
        $args = array_merge([$prev], $this->resolveDependencies($c));

        return call_user_func_array($this->factoryFn, $args);
    }
}
