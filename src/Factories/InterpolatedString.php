<?php

namespace Dhii\Modular\Module\Factories;

use Psr\Container\ContainerInterface;

class InterpolatedString extends AbstractFactory
{
    /**
     * @since [*next-version*]
     *
     * @var string
     */
    protected $format;

    /**
     * Constructor.
     *
     * @since [*next-version*]
     *
     * @param string $format       A format string. Occurrences of indexes in the $dependencies array wrapped in braces
     *                             will be interpolated the value of the corresponding dependent services.
     * @param array  $dependencies The keys of dependent services.
     */
    public function __construct(string $format, array $dependencies)
    {
        parent::__construct($dependencies);

        $this->format = $format;
    }

    /**
     * @inheritdoc
     *
     * @since [*next-version*]
     */
    public function __invoke(ContainerInterface $c)
    {
        $replace = [];
        foreach ($this->dependencies as $idx => $dependency) {
            $replace['{' . $idx . '}'] = strval($c->get($dependency));
        }

        return strtr($this->format, $replace);
    }
}
