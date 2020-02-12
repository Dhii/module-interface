<?php

namespace Dhii\Modular\Module\UnitTest\Module;

use Dhii\Modular\Module\ModularInterface;
use Dhii\Modular\Module\ModuleInterface;
use Dhii\Modular\Module\Modules\ModularModule as TestSubject;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use ReflectionException;

class ModularModuleTest extends TestCase
{
    /**
     * @since [*next-version*]
     */
    public function testConstruct()
    {
        $subject = new TestSubject([]);

        static::assertInstanceOf(ModuleInterface::class, $subject);
        static::assertInstanceOf(ModularInterface::class, $subject);
    }

    /**
     * @since [*next-version*]
     *
     * @throws ReflectionException
     */
    public function testGetFactories()
    {
        {
            $key1 = uniqid('key1');
            $key2 = uniqid('key2');
            $key3 = uniqid('key3');

            $fac1 = uniqid('fac1');
            $fac2 = uniqid('fac2');
            $fac3 = uniqid('fac3');
            $fac4 = uniqid('fac4');

            $factories1 = [
                $key1 => $fac1,
                $key2 => $fac2,
            ];

            $factories2 = [
                $key2 => $fac4,
                $key3 => $fac3,
            ];
        }
        {
            /** @var ModuleInterface|MockObject $module1 */
            /** @var ModuleInterface|MockObject $module2 */
            $module1 = $this->getMockForAbstractClass(ModuleInterface::class);
            $module2 = $this->getMockForAbstractClass(ModuleInterface::class);

            $module1->expects(static::once())->method('getFactories')->willReturn($factories1);
            $module2->expects(static::once())->method('getFactories')->willReturn($factories2);
        }

        $subject = new TestSubject([$module1, $module2]);
        $actual = $subject->getFactories();

        static::assertSame($fac1, $actual[$key1]);
        static::assertSame($fac4, $actual[$key2]);
        static::assertSame($fac3, $actual[$key3]);
    }

    /**
     * @since [*next-version*]
     *
     * @throws ReflectionException
     */
    public function testGetExtensions()
    {
        {
            $key1 = uniqid('key1');
            $key2 = uniqid('key2');
            $key3 = uniqid('key3');

            $ext1 = uniqid('ext1');
            $ext2 = uniqid('ext2');
            $ext3 = uniqid('ext4');
            $ext4 = uniqid('ext5');

            $extensions1 = [
                $key1 => $ext1,
                $key2 => $ext2,
            ];

            $extensions2 = [
                $key2 => $ext4,
                $key3 => $ext3,
            ];
        }
        {
            /** @var ModuleInterface|MockObject $module1 */
            /** @var ModuleInterface|MockObject $module2 */
            $module1 = $this->getMockForAbstractClass(ModuleInterface::class);
            $module2 = $this->getMockForAbstractClass(ModuleInterface::class);

            $module1->expects(static::once())->method('getExtensions')->willReturn($extensions1);
            $module2->expects(static::once())->method('getExtensions')->willReturn($extensions2);
        }

        $subject = new TestSubject([$module1, $module2]);
        $actual = $subject->getExtensions();

        static::assertSame($ext1, $actual[$key1]);
        static::assertSame($ext3, $actual[$key3]);

        // The combined extension is neither of the exising ones, but still callable
        static::assertNotSame($ext2, $actual[$key2]);
        static::assertNotSame($ext4, $actual[$key2]);
        static::assertIsCallable($actual[$key2]);
    }

    /**
     * @since [*next-version*]
     *
     * @throws ReflectionException
     */
    public function testRun()
    {
        {
            $c = $this->getMockForAbstractClass(ContainerInterface::class);
        }
        {
            /** @var ModuleInterface|MockObject $module1 */
            /** @var ModuleInterface|MockObject $module2 */
            $module1 = $this->getMockForAbstractClass(ModuleInterface::class);
            $module2 = $this->getMockForAbstractClass(ModuleInterface::class);

            $module1->expects(static::once())->method('run')->with($c);
            $module2->expects(static::once())->method('run')->with($c);
        }

        $subject = new TestSubject([$module1, $module2]);
        $subject->run($c);
    }
}
