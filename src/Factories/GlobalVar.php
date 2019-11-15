<?php

namespace Dhii\Modular\Module\Factories;

use Dhii\Modular\Module\FactoryInterface;
use Psr\Container\ContainerInterface;

/**
 * A service factory for referencing global variables.
 *
 * @since [*next-version*]
 */
class GlobalVar implements FactoryInterface
{
    /**
     * @since [*next-version*]
     *
     * @var string
     */
    protected $name;

    /**
     * Constructor.
     *
     * @since [*next-version*]
     *
     * @param string $name The name of the global variable.
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * @inheritdoc
     *
     * @since [*next-version*]
     */
    public function getDependencies() : array
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
        global ${$this->name};

        return ${$this->name};
    }
}
