<?php

namespace Dhii\Modular\Module\Exception;

use Dhii\Modular\Module\ModuleInterface;
use Exception;
use Throwable;

/**
 * An exception that is thrown in relation to a module that failed to be set up or run.
 *
 * @since [*next-version*]
 */
class ModuleException extends Exception
{
    /**
     * @since [*next-version*]
     *
     * @var ModuleInterface|null
     */
    protected $module;

    /**
     * @inheritdoc
     *
     * @since [*next-version*]
     *
     * @param ModuleInterface|null $module The module that erred, if any.
     */
    public function __construct($message = '', $code = 0, Throwable $previous = null, ModuleInterface $module = null)
    {
        parent::__construct($message, $code, $previous);

        $this->module = $module;
    }

    /**
     * Retrieves the module that erred, if any.
     *
     * @since [*next-version*]
     *
     * @return ModuleInterface|null A module instance or null.
     */
    public function getModule()
    {
        return $this->module;
    }
}
