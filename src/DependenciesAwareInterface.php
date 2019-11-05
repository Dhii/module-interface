<?php

namespace Dhii\Modular\Module;

use Dhii\Util\String\StringableInterface as Stringable;
use stdClass;
use Traversable;

/**
 * Something that is aware of, and can provide, a list of dependencies.
 *
 * @since [*next-version*]
 */
interface DependenciesAwareInterface
{
    /**
     * Retrieves the dependencies.
     *
     * @since [*next-version*]
     *
     * @return string[]|Stringable[]|stdClass|Traversable A list of dependencies.
     */
    public function getDependencies();
}
