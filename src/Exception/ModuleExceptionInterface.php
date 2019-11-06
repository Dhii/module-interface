<?php

namespace Dhii\Modular\Module\Exception;

use Dhii\Modular\Module\ModuleAwareInterface;
use Throwable;

/**
 * Represents an exception that is thrown in relation to a module.
 *
 * @since [*next-version*]
 */
interface ModuleExceptionInterface extends
    Throwable,
    ModuleAwareInterface
{
}
