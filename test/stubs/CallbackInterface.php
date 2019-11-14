<?php

namespace Dhii\Modular\Module\Test;

/**
 * Interface used for creating mock callbacks. Useful for setting expectations on callbacks.
 *
 * @since [*next-version*]
 */
interface CallbackInterface
{
    /**
     * @since [*next-version*]
     */
    public function __invoke();
}
