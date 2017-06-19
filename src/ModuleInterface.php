<?php

namespace Dhii\Modular\Module;

use Dhii\Data\KeyAwareInterface;

/**
 * Anything that represents a system module.
 *
 * A module is represented by an key, which is not limited to any type or form. It can be numeric, a slug, a hash or
 * even a user-friendly name. What matters is that it **uniquely** identifies the module.
 *
 * @since [*next-version*]
 */
interface ModuleInterface extends KeyAwareInterface
{
    /**
     * Performs module-specific loading procedures.
     *
     * May result in no actions taking place at all.
     *
     * @since [*next-version*]
     */
    public function load();
}
