<?php

namespace Mecha\Modular\Modules;

use Mecha\Modular\ExtensionInterface;
use Mecha\Modular\FactoryInterface;
use Mecha\Modular\ModularInterface;
use Mecha\Modular\ModuleInterface;
use Psr\Container\ContainerInterface;

/**
 * An implementation of a module that is composed of other modules.
 *
 * Modules of this implementation will compile and cache the merged factories and extensions of their child modules,
 * which are then provided via the {@link ModuleInterface::getFactories()} and {@link ModuleInterface::getExtensions()}
 * methods. When modular modules are run, each child module is also run with the same container in the order they are
 * given during construction.
 *
 * This class may be freely extended and used as a base for modular applications.
 * The {@link ModularModule::getSelfFactories()} and {@link ModularModule::getSelfExtensions()} methods may be
 * overridden to specify factories and extensions at the top level of the composition.
 *
 * The list of child modules does not need to be associative. However, it may be helpful to associate each module with
 * a key to allow for easy referencing of specific modules, such as automating the prefixing of each module via the
 * {@link PrefixingModule} decorator, using each module's key as the prefix.
 *
 * Example usage:
 *  ```
 *  $app = new ModularModule([
 *      'log' => new LogModule(),
 *      'db'  => new DbModule(),
 *      'cms' => new CmsModule(),
 *  ]);
 *
 *  $app->run($c);
 *  ```
 *
 * @since [*next-version*]
 */
class ModularModule implements ModuleInterface, ModularInterface
{
    /**
     * @since [*next-version*]
     *
     * @var ModuleInterface[]
     */
    protected $modules;

    /**
     * @since [*next-version*]
     *
     * @var FactoryInterface[]
     */
    protected $factories;

    /**
     * @since [*next-version*]
     *
     * @var ExtensionInterface[]
     */
    protected $extensions;

    /**
     * Constructor.
     *
     * @since [*next-version*]
     *
     * @param ModuleInterface[] $modules The modules.
     */
    public function __construct(array $modules)
    {
        $this->modules = $modules;

        $this->compileServices();
    }

    /**
     * @inheritDoc
     */
    public function getFactories() : array
    {
        return $this->factories;
    }

    /**
     * @inheritDoc
     */
    public function getExtensions() : array
    {
        return $this->extensions;
    }

    /**
     * @inheritDoc
     */
    public function run(ContainerInterface $c)
    {
        foreach ($this->modules as $module) {
            $module->run($c);
        }
    }

    /**
     * Retrieves the list of modules.
     *
     * @since [*next-version*]
     *
     * @return ModuleInterface[]
     */
    public function getModules() : array
    {
        return $this->modules;
    }

    /**
     * Retrieves the modular module's own factories.
     *
     * @since [*next-version*]
     *
     * @return FactoryInterface[]
     */
    protected function getSelfFactories() : array
    {
        return [];
    }

    /**
     * Retrieves the modular module's own extensions.
     *
     * @since [*next-version*]
     *
     * @return ExtensionInterface[]
     */
    protected function getSelfExtensions() : array
    {
        return [];
    }

    /**
     * Compiles all of the module services.
     *
     * @since [*next-version*]
     */
    protected function compileServices()
    {
        $this->factories = $this->getSelfFactories();
        $this->extensions = $this->getSelfExtensions();

        foreach ($this->modules as $module) {
            $this->factories = array_merge($this->factories, $module->getFactories());
            $moduleExtensions = $module->getExtensions();

            if (empty($this->extensions)) {
                $this->extensions = $moduleExtensions;
                continue;
            }

            foreach ($moduleExtensions as $key => $extension) {
                if (!array_key_exists($key, $this->extensions)) {
                    $this->extensions[$key] = $extension;
                    continue;
                }

                $prevExtension = $this->extensions[$key];
                $this->extensions[$key] = function (ContainerInterface $c, $prev) use ($prevExtension, $extension) {
                    return $extension($c, $prevExtension($c, $prev));
                };
            }
        }
    }
}
