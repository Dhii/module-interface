<?php

namespace Mecha\Modular\Services;

use Mecha\Modular\FactoryInterface;
use Psr\Container\ContainerInterface;

/**
 * A service factory for referencing global variables.
 *
 * Example usage:
 *  ```
 *  global $var;
 *  $var = 5;
 *
 *  [
 *      'service_a' => new GlobalVar('var')
 *  ]
 *
 *  $c->get('service_a'); // 5
 *  ```
 *
 * @since [*next-version*]
 */
class GlobalVar extends AbstractService implements FactoryInterface
{
    /**
     * @since [*next-version*]
     *
     * @var string
     */
    protected $name;

    /**
     * Constructor.
     *
     * @since [*next-version*]
     *
     * @param string $name The name of the global variable.
     */
    public function __construct(string $name)
    {
        parent::__construct([]);

        $this->name = $name;
    }

    /**
     * @inheritdoc
     *
     * @since [*next-version*]
     */
    public function __invoke(ContainerInterface $c)
    {
        global ${$this->name};

        return ${$this->name};
    }
}
