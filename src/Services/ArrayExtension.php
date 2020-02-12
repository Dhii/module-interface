<?php

namespace Mecha\Modular\Services;

use Mecha\Modular\ExtensionInterface;
use Psr\Container\ContainerInterface;

/**
 * An extension implementation that extends an array service.
 *
 * This implementation uses {@link array_merge()} to extend the original array service. This means that positional
 * entries are not overwritten, but associative entries are.
 *
 * Example usage:
 *  ```
 *  // Factories
 *  [
 *      'menu_links' => new Value([]),
 *      'home_link' => new Value('Home'),
 *      'blog_link' => new Value('Blog'),
 *      'about_link' => new Value('About Us'),
 *  ]
 *  // Extensions
 *  [
 *      'menu_links' => new ArrayExtension([
 *          'home_link',
 *          'blog_link',
 *          'about_link',
 *      ]),
 *  ]
 *  ```
 *
 * @since [*next-version*]
 */
class ArrayExtension extends AbstractService implements ExtensionInterface
{
    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $c, $prev)
    {
        return array_merge($prev, $this->resolveDependencies($c));
    }
}
