<?php

namespace Dhii\Modular\Module;

use Dhii\Factory\FactoryInterface;

/**
 * Something that can create new module instances from module configuration.
 *
 * @since [*next-version*]
 */
interface ModuleFactoryInterface extends FactoryInterface
{
    /**
     * {@inheritdoc}
     *
     * @since [*next-version*]
     *
     * @return ModuleInterface The created module instance.
     */
    public function make($config = null);
}
