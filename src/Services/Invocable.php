<?php

namespace Dhii\Modular\Module\Services;

use Dhii\Modular\Module\FactoryInterface;
use Psr\Container\ContainerInterface;

/**
 * A factory implementation that returns an invocable function.
 *
 * The callback's arguments will be equivalent to the service instances that correspond with the `Invocable` instance's
 * dependency keys, in the order they are given. Those service are fetched only once when the `Invocable` is invoked and
 * the callback is returned, not when the _returned_ callback is invoked. They are then "cached" in the returned
 * callback's scope.
 *
 * Example usage:
 *  ```
 *  [
 *      'service_a' => function () {
 *          return "hello";
 *      },
 *      'service_b' => function () {
 *          return "world";
 *      },
 *      'service_c' => new Invocable(['service_a', 'service_b'], function ($a, $b) {
 *          return "$a $b";
 *      })
 *  ]
 *
 *  $fn = $c->get('service_c');
 *  echo $fn(); // "hello world"
 *  ```
 *
 * @since [*next-version*]
 */
class Invocable extends AbstractService implements FactoryInterface
{
    /**
     * @since [*next-version*]
     *
     * @var callable
     */
    protected $function;

    /**
     * Constructor.
     *
     * @since [*next-version*]
     *
     * @param string[] $dependencies The keys of dependent services.
     * @param callable $function     The function to return for this service.
     */
    public function __construct(array $dependencies, callable $function)
    {
        parent::__construct($dependencies);

        $this->function = $function;
    }

    /**
     * @inheritdoc
     *
     * @since [*next-version*]
     */
    public function __invoke(ContainerInterface $c)
    {
        $deps = $this->resolveDependencies($c);

        return function () use ($deps) {
            return ($this->function)(...$deps);
        };
    }
}
