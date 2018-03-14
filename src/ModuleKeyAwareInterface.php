<?php

namespace Dhii\Modular\Module;

use Dhii\Util\String\StringableInterface as Stringable;

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
     * @return string|Stringable|null The key, if applicable; otherwise, null.
     */
    public function getModuleKey();
}
