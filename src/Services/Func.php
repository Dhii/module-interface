<?php

namespace Mecha\Modular\Services;

use Mecha\Modular\FactoryInterface;
use Psr\Container\ContainerInterface;

/**
 * A factory implementation that returns an invocable function.
 *
 * The function's arguments will be equivalent to any invocation arguments first, followed by the service instances
 * that correspond with the `Func` instance's dependency keys, in the order they are given.
 *
 * Those service are fetched only once when the `Func` is invoked and the function is returned, not when the
 * _returned_ function is invoked. They are then "cached" in the returned function's scope.
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
 *      'service_c' => new Invocable(['service_a', 'service_b'], function ($x, $a, $b) {
 *          return "$x $a $b";
 *      })
 *  ]
 *
 *  $fn = $c->get('service_c');
 *  echo $fn('Yo!'); // "Yo! hello world"
 *  ```
 *
 * @since [*next-version*]
 */
class Func extends AbstractService implements FactoryInterface
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

        return function (...$args) use ($deps) {
            return ($this->function)(...$args, ...$deps);
        };
    }
}
