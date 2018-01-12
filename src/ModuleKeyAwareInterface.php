<?php

namespace Dhii\Modular\Module;

/**
 * Something that can have a module key retrieved.
 *
 * @since [*next-version*]
 */
interface ModuleKeyAwareInterface
{
    /**
     * Retrieves the module key associated with this instance.
     *
     * @since [*next-version*]
     *
     * @return string|null The key, if applicable; otherwise, null.
     */
    public function getModuleKey();
}
