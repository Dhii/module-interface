<?php

namespace Dhii\Modular\Module\Factories;

use Dhii\Modular\Module\FactoryInterface;

/**
 * A partial implementation of a factory that is aware of a list of dependency keys.
 *
 * @since [*next-version*]
 */
abstract class AbstractFactory implements FactoryInterface
{
    /**
     * @since [*next-version*]
     *
     * @var string[]
     */
    protected $dependencies;

    /**
     * Constructor.
     *
     * @since [*next-version*]
     *
     * @param string[] $dependencies The keys of dependent services.
     */
    public function __construct(array $dependencies)
    {
        $this->dependencies = $dependencies;
    }

    /**
     * @inheritdoc
     *
     * @since [*next-version*]
     */
    public function getDependencies()
    {
        return $this->dependencies;
    }
}
