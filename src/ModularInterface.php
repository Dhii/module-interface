<?php

namespace Mecha\Modular;

/**
 * Interface for something that is modular and can provide its list of modules.
 *
 * @since [*next-version*]
 */
interface ModularInterface
{
    /**
     * Retrieves the list of modules.
     *
     * @since [*next-version*]
     *
     * @return ModuleInterface[]
     */
    public function getModules() : array;
}
