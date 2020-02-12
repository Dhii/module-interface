<?php

namespace Mecha\Modular\UnitTest\Services;

use Mecha\Modular\ExtensionInterface;
use Mecha\Modular\Services\ArrayExtension as TestSubject;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use ReflectionException;

class ArrayExtensionTest extends TestCase
{
    /**
     * @since [*next-version*]
     */
    public function testConstruct()
    {
        $subject = new TestSubject([]);

        static::assertInstanceOf(ExtensionInterface::class, $subject);
    }

    /**
     * @since [*next-version*]
     */
    public function testGetDependencies()
    {
        $deps = [
            uniqid('dep1'),
            uniqid('dep2'),
            uniqid('dep3'),
        ];
        $subject = new TestSubject($deps);

        static::assertSame($deps, $subject->getDependencies());
    }

    /**
     * @since [*next-version*]
     *
     * @throws ReflectionException
     */
    public function testInvoke()
    {
        {
            $dep1 = uniqid('dep1');
            $dep2 = uniqid('dep2');

            $val1 = uniqid('str1');
            $val2 = uniqid('str2');
        }
        {
            $prev1 = uniqid('prev1');
            $prev2 = uniqid('prev2');

            $prev = [$prev1, $prev2];
            $expected = [$prev1, $prev2, $val1, $val2];
        }
        {
            /* @var $container MockObject|ContainerInterface */
            $container = $this->getMockForAbstractClass(ContainerInterface::class);
            $container->expects(static::exactly(2))
                      ->method('get')
                      ->withConsecutive([$dep1], [$dep2])
                      ->willReturnOnConsecutiveCalls($val1, $val2);
        }
        {
            $subject = new TestSubject([$dep1, $dep2]);
        }

        static::assertSame($expected, $subject($container, $prev));
    }
}
