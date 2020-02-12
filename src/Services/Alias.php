<?php

namespace Mecha\Modular\Services;

use Mecha\Modular\FactoryInterface;
use Psr\Container\ContainerInterface;

/**
 * A service factory that simply resolves to another existing service, and can optionally default to another factory.
 *
 * Example usage:
 *  ```
 *  [
 *      'service_a' => new Alias('service_b'),
 *      'service_b' => function() {
 *          return "hello";
 *      }
 *      'service_c' => new Alias('service_d', function () {
 *          return "default";
 *      }),
 *  ]
 *
 *  $c->get('service_a'); // "hello"
 *  $c->get('service_c'); // "default"
 *  ```
 *
 * @since [*next-version*]
 */
class Alias extends AbstractService implements FactoryInterface
{
    /**
     * @since [*next-version*]
     *
     * @var string
     */
    public $key;

    /**
     * @since [*next-version*]
     *
     * @var callable|null
     */
    protected $factoryFn;

    /**
     * Constructor.
     *
     * @since [*next-version*]
     *
     * @param string        $key       The key of the service to alias.
     * @param callable|null $factoryFn The factory function to invoke if the original service does not exist, or null
     *                                 to return a service value of null.
     */
    public function __construct(string $key, callable $factoryFn = null)
    {
        parent::__construct([]);

        $this->key = $key;
        $this->factoryFn = $factoryFn;
    }

    /**
     * @inheritdoc
     *
     * @since [*next-version*]
     */
    public function __invoke(ContainerInterface $c)
    {
        if ($c->has($this->key)) {
            return $c->get($this->key);
        }

        if ($this->factoryFn === null) {
            return null;
        }

        return call_user_func_array($this->factoryFn, [$c]);
    }
}
