<?php

namespace Dhii\Modular\Module\UnitTest\Services;

use Dhii\Modular\Module\Services\FormatStr as TestSubject;
use Dhii\Modular\Module\FactoryInterface;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use Psr\Container\ContainerInterface;

/**
 * @since [*next-version*]
 */
class FormatStrTest extends TestCase
{
    /**
     * @since [*next-version*]
     */
    public function testConstruct()
    {
        $subject = new TestSubject('', []);

        static::assertInstanceOf(FactoryInterface::class, $subject);
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
        $subject = new TestSubject('', $deps);

        static::assertSame($deps, $subject->getDependencies());
    }

    /**
     * @since [*next-version*]
     */
    public function testInvoke()
    {
        {
            $dep1 = uniqid('dep1');
            $dep2 = uniqid('dep2');

            $str1 = uniqid('str1');
            $str2 = uniqid('str2');
        }
        {
            /* @var $container MockObject|ContainerInterface */
            $container = $this->getMockForAbstractClass(ContainerInterface::class);
            $container->expects(static::exactly(2))
                      ->method('get')
                      ->withConsecutive([$dep1], [$dep2])
                      ->willReturnOnConsecutiveCalls($str1, $str2);
        }
        {
            $subject = new TestSubject('Foo {0} Bar {1}', [$dep1, $dep2]);
            $expected = sprintf('Foo %s Bar %s', $str1, $str2);
        }

        static::assertSame($expected, $subject($container));
    }
}
