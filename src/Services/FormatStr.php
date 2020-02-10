<?php

namespace Dhii\Modular\Module\Services;

use Dhii\Modular\Module\FactoryInterface;
use Psr\Container\ContainerInterface;

/**
 * A factory for string values. Supports interpolation with dependent service values.
 *
 * Example usage:
 *  ```
 *  [
 *      'service_a' => new FormatStr('John Smith'),
 *      'service_b' => new FormatStr('User name is: {0}', ['service_a']),
 *      'service_c' => new FormatStr('{day} {month}', [
 *          'day'   => 'date/day',
 *          'month' => 'date/month',
 *      ]),
 *  ]
 *  ```
 *
 * @since [*next-version*]
 */
class FormatStr extends AbstractService implements FactoryInterface
{
    /**
     * @since [*next-version*]
     *
     * @var string
     */
    protected $string;

    /**
     * Constructor.
     *
     * @since [*next-version*]
     *
     * @param string $format       The string. Occurrences of indexes in the $dependencies array wrapped in braces
     *                             will be interpolated the value of the corresponding dependent services.
     * @param array  $dependencies The keys of dependent services to use for interpolation.
     */
    public function __construct(string $format, array $dependencies = [])
    {
        parent::__construct($dependencies);

        $this->string = $format;
    }

    /**
     * @inheritdoc
     *
     * @since [*next-version*]
     */
    public function __invoke(ContainerInterface $c)
    {
        if (empty($this->dependencies)) {
            return $this->string;
        }

        $replace = [];
        foreach ($this->dependencies as $idx => $dependency) {
            $replace['{' . $idx . '}'] = strval($c->get($dependency));
        }

        return strtr($this->string, $replace);
    }
}
