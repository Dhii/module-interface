<?php

namespace Dhii\Modular\Module\Factories;

use Dhii\Modular\Module\FactoryInterface;
use Psr\Container\ContainerInterface;

/**
 * A simple factory implementation that returns a static value. Useful for configuration.
 *
 * @since [*next-version*]
 */
class Value implements FactoryInterface
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
        $this->value = $value;
    }

    /**
     * @inheritdoc
     *
     * @since [*next-version*]
     */
    public function getDependencies()
    {
        return [];
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
