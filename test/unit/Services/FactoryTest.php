<?php

namespace Mecha\Modular\UnitTest\Services;

use Mecha\Modular\Services\Factory as TestSubject;
use Mecha\Modular\FactoryInterface;
use Mecha\Modular\Test\CallbackInterface;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use Psr\Container\ContainerInterface;

/**
 * @since [*next-version*]
 */
class FactoryTest extends TestCase
{
    /**
     * @since [*next-version*]
     */
    public function testConstruct()
    {
        $subject = new TestSubject([], function () {});

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

        $subject = new TestSubject($deps, function () {});

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

            $result = uniqid('result');
        }
        {
            /* @var $callback MockObject|callable */
            $callback = $this->getMockForAbstractClass(CallbackInterface::class);
            $callback->expects(static::once())
                     ->method('__invoke')
                     ->with($service1, $service2)
                     ->willReturn($result);
        }
        {
            /* @var $container MockObject|ContainerInterface */
            $container = $this->getMockForAbstractClass(ContainerInterface::class);
            $container->expects(static::exactly(2))
                      ->method('get')
                      ->withConsecutive([$dep1], [$dep2])
                      ->willReturnOnConsecutiveCalls($service1, $service2);
        }

        $subject = new TestSubject([$dep1, $dep2], $callback);

        self::assertSame($result, $subject($container));
    }
}
