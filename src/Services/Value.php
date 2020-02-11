<?php

namespace Dhii\Modular\Module\Services;

use Dhii\Modular\Module\FactoryInterface;
use Psr\Container\ContainerInterface;

/**
 * A simple factory implementation that returns a static value. Useful for configuration.
 *
 * Example usage:
 *  ```
 *  [
 *      'value_a' => new Value(2),
 *      'value_b' => new Value('hello'),
 *      'value_c' => new Value($someVar),
 *  ]
 *
 *  $c->get('value_a'); // 2
 *  $c->get('value_b'); // 'hello'
 *  $c->get('value_c'); // value of $someVar
 *  ```
 *
 * @since [*next-version*]
 */
class Value extends AbstractService implements FactoryInterface
{
    /**
     * @since [*next-version*]
     *
     * @var mixed
     */
    protected $value;

    /**
     * Constructor.
     *
     * @since [*next-version*]
     *
     * @param mixed $value The value.
     */
    public function __construct($value)
    {
        parent::__construct([]);

        $this->value = $value;
    }

    /**
     * @inheritdoc
     *
     * @since [*next-version*]
     */
    public function __invoke(ContainerInterface $c)
    {
        return $this->value;
    }
}
