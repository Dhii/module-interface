<?php

namespace Mecha\Modular\UnitTest\Modules;

use Mecha\Modular\ExtensionInterface;
use Mecha\Modular\FactoryInterface;
use Mecha\Modular\ModuleInterface;
use Mecha\Modular\Modules\PrefixingModule as TestSubject;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use ReflectionException;

class PrefixingModuleTest extends TestCase
{
    /**
     * @since [*next-version*]
     *
     * @throws ReflectionException
     */
    public function testConstruct()
    {
        /** @var ModuleInterface|MockObject $module */
        $module = $this->getMockForAbstractClass(ModuleInterface::class);
        $subject = new TestSubject("", $module);

        static::assertInstanceOf(ModuleInterface::class, $subject);
    }

    /**
     * @since [*next-version*]
     *
     * @throws ReflectionException
     */
    public function testGetFactories()
    {
        $prefix = uniqid('prefix');

        {
            $key1 = uniqid('key1');
            $key2 = uniqid('key2');

            /** @var FactoryInterface|MockObject $fac1 */
            /** @var FactoryInterface|MockObject $fac2 */
            $fac1 = $this->getMockForAbstractClass(FactoryInterface::class);
            $fac2 = $this->getMockForAbstractClass(FactoryInterface::class);

            // Factories list
            $factories = [
                $key1 => $fac1,
                $key2 => $fac2,
            ];
        }
        {
            // Factory dependencies
            $deps1 = [$key2, 'external1'];
            $deps2 = ['external2'];

            $fac1->expects(static::once())->method('getDependencies')->willReturn($deps1);
            $fac2->expects(static::once())->method('getDependencies')->willReturn($deps2);
        }
        {
            // Prefixed dependencies
            $pDeps1 = [$prefix . $key2, 'external1'];
            $pDeps2 = ['external2'];

            // New factory mock instances
            /** @var FactoryInterface|MockObject $facVal1 */
            /** @var FactoryInterface|MockObject $facVal2 */
            $newFac1 = $this->getMockForAbstractClass(FactoryInterface::class);
            $newFac2 = $this->getMockForAbstractClass(FactoryInterface::class);

            // Old factories create new ones
            $fac1->expects(static::once())->method('withDependencies')->with($pDeps1)->willReturn($newFac1);
            $fac2->expects(static::once())->method('withDependencies')->with($pDeps2)->willReturn($newFac2);
        }
        {
            /** @var ModuleInterface|MockObject $module */
            $module = $this->getMockForAbstractClass(ModuleInterface::class);

            $module->expects(static::once())->method('getFactories')->willReturn($factories);
        }

        $subject = new TestSubject($prefix, $module);
        $expected = [
            $prefix . $key1 => $newFac1,
            $prefix . $key2 => $newFac2,
        ];

        static::assertSame($expected, $subject->getFactories());
    }

    /**
     * @since [*next-version*]
     *
     * @throws ReflectionException
     */
    public function testGetExtensions()
    {
        $prefix = uniqid('prefix');

        {
            $key1 = uniqid('key1');
            $key2 = uniqid('key2');

            /** @var ExtensionInterface|MockObject $ext1 */
            /** @var ExtensionInterface|MockObject $ext2 */
            $ext1 = $this->getMockForAbstractClass(ExtensionInterface::class);
            $ext2 = $this->getMockForAbstractClass(ExtensionInterface::class);

            // Factories list
            $factories = [
                $key1 => $ext1,
                $key2 => $ext2,
            ];
        }
        {
            // Extension dependencies
            $deps1 = [$key2, 'external1'];
            $deps2 = ['external2'];

            $ext1->expects(static::once())->method('getDependencies')->willReturn($deps1);
            $ext2->expects(static::once())->method('getDependencies')->willReturn($deps2);
        }
        {
            // Prefixed dependencies
            $pDeps1 = [$prefix . $key2, 'external1'];
            $pDeps2 = ['external2'];

            /** @var ExtensionInterface|MockObject $facVal1 */
            /** @var ExtensionInterface|MockObject $facVal2 */
            $newExt1 = $this->getMockForAbstractClass(ExtensionInterface::class);
            $newExt2 = $this->getMockForAbstractClass(ExtensionInterface::class);

            // Old extensions create new ones
            $ext1->expects(static::once())->method('withDependencies')->with($pDeps1)->willReturn($newExt1);
            $ext2->expects(static::once())->method('withDependencies')->with($pDeps2)->willReturn($newExt2);
        }
        {
            /** @var ModuleInterface|MockObject $module */
            $module = $this->getMockForAbstractClass(ModuleInterface::class);

            $module->expects(static::once())->method('getExtensions')->willReturn($factories);
        }

        $subject = new TestSubject($prefix, $module);
        $expected = [
            $prefix . $key1 => $newExt1,
            $prefix . $key2 => $newExt2,
        ];

        static::assertSame($expected, $subject->getExtensions());
    }

    /**
     * @since [*next-version*]
     *
     * @throws ReflectionException
     */
    public function testRun()
    {
        $prefix = uniqid('prefix');

        {
            $key1 = uniqid('key1');
            $key2 = uniqid('key2');

            $pKey1 = $prefix . $key1;
            $pKey2 = $prefix . $key2;
        }
        {
            /** @var ModuleInterface|MockObject $module */
            $module = $this->getMockForAbstractClass(ModuleInterface::class);

            $module->expects(static::once())->method('run')->willReturnCallback(
                function (ContainerInterface $c) use ($key1, $key2) {
                    // Assert that the container still has the original keys
                    static::assertTrue($c->has($key1));
                    static::assertTrue($c->has($key2));
                }
            );
        }
        {
            /** @var ContainerInterface|MockObject $c */
            $c = $this->getMockForAbstractClass(ContainerInterface::class);

            $c->expects(static::exactly(2))
              ->method('has')
              ->withConsecutive([$pKey1], [$pKey2])
              ->willReturn(true);
        }

        $subject = new TestSubject($prefix, $module);

        $subject->run($c);
    }
}
