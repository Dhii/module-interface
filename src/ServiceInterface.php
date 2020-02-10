<?php

namespace Dhii\Modular\Module;

/**
 * Represents a service that is provided by a module.
 *
 * @since [*next-version*]
 */
interface ServiceInterface
{
    /**
     * Retrieves the keys of dependent services.
     *
     * @since [*next-version*]
     *
     * @return string[] A list of strings each representing the key of a service.
     */
    public function getDependencies() : array;
}
