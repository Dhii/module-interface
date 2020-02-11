<?php

namespace Dhii\Modular\Module\Services;

use Dhii\Modular\Module\FactoryInterface;
use Psr\Container\ContainerInterface;

/**
 * A standard service factory implementation.
 *
 * Example usage:
 *  ```
 *  [
 *      'service_a' => new Factory([], function () {
 *          return 'hello';
 *      }),
 *      'service_b' => new Factory([], function () {
 *          return 'world';
 *      }),
 *      'service_c' => new Factory(['service_a', 'service_b'], function ($a, $b) {
 *          return "$a $b";
 *      }),
 *  ]
 *
 *  $c->get('service_c'); // "hello world"
 *  ```
 *
 * @since [*next-version*]
 */
class Factory extends AbstractService implements FactoryInterface
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
     * @param callable $factoryFn    The factory function that creates the service instance. Receives the dependent
     *                               service instances as arguments, in the order they are given in $dependencies.
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
    public function __invoke(ContainerInterface $c)
    {
        return call_user_func_array($this->factoryFn, $this->resolveDependencies($c));
    }
}
