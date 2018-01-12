<?php

namespace Dhii\Modular\Module\Exception;

use Dhii\Modular\Module\ModuleAwareInterface;
use Dhii\Exception\ThrowableInterface;

/**
 * Represents an exception that is thrown in relation to a module.
 *
 * @since [*next-version*]
 */
interface ModuleExceptionInterface extends
    ThrowableInterface,
    ModuleAwareInterface
{
}
