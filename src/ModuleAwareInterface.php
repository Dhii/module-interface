<?php

namespace Dhii\Modular\Module;

/**
 * Something that can have a module instance retrieved.
 *
 * @since [*next-version*]
 */
interface ModuleAwareInterface
{
    /**
     * Retrieves the module that is associated with this instance.
     *
     * @since [*next-version*]
     *
     * @return ModuleInterface|null The module, if applicable; otherwise, null.
     */
    public function getModule();
}
