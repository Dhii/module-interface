<?php

namespace Dhii\Modular\Module\UnitTest\Factories;

use Dhii\Modular\Module\Factories\Callback as TestSubject;
use Dhii\Modular\Module\FactoryInterface;
use Dhii\Modular\Module\Test\CallbackInterface;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use Psr\Container\ContainerInterface;

/**
 * @since [*next-version*]
 */
class CallbackTest extends TestCase
{
    /**
     * @since [*next-version*]
     */
    public function testConstruct()
    {
        $subject = new TestSubject([], function () {
        });

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

        $subject = new TestSubject($deps, function () {
        });

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

            $service1 = uniqid('service1');
            $service2 = uniqid('service2');
        }
        {
            $return = uniqid('return');

            /* @var $callback MockObject|callable */
            $callback = $this->getMockForAbstractClass(CallbackInterface::class);
            $callback->expects(static::once())
                     ->method('__invoke')
                     ->with($service1, $service2)
                     ->willReturn($return);
        }
        {
            /* @var $container MockObject|ContainerInterface */
            $container = $this->getMockForAbstractClass(ContainerInterface::class);
            $container->expects(static::exactly(2))
                      ->method('get')
                      ->withConsecutive([$dep1], [$dep2])
                      ->willReturnOnConsecutiveCalls($service1, $service2);
        }
        {
            $subject = new TestSubject([$dep1, $dep2], $callback);
        }

        $result = $subject($container);

        static::assertInternalType('callable', $result);
        static::assertSame($return, $result());
    }
}
