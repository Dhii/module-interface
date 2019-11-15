<?php

namespace Dhii\Modular\Module\UnitTest\Factories;

use Dhii\Modular\Module\Factories\Alias as TestSubject;
use Dhii\Modular\Module\FactoryInterface;
use Dhii\Modular\Module\Test\CallbackInterface;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use Psr\Container\ContainerInterface;

/**
 * @since [*next-version*]
 */
class AliasTest extends TestCase
{
    /**
     * @since [*next-version*]
     */
    public function testConstruct()
    {
        $subject = new TestSubject('');

        static::assertInstanceOf(FactoryInterface::class, $subject);
    }

    /**
     * @since [*next-version*]
     */
    public function testGetDependencies()
    {
        $subject = new TestSubject('');

        static::assertEmpty($subject->getDependencies());
    }

    /**
     * @since [*next-version*]
     */
    public function testInvoke()
    {
        {
            $key = uniqid('key');
            $service = uniqid('service');
        }
        {
            /* @var $container MockObject|ContainerInterface */
            $container = $this->getMockForAbstractClass(ContainerInterface::class);

            $container->expects(static::exactly(1))
                      ->method('has')
                      ->with($key)
                      ->willReturn(true);

            $container->expects(static::exactly(1))
                      ->method('get')
                      ->with($key)
                      ->willReturn($service);
        }

        $subject = new TestSubject($key);

        self::assertSame($service, $subject($container));
    }

    /**
     * @since [*next-version*]
     */
    public function testInvokeDefault()
    {
        {
            $key = uniqid('key');
            $default = uniqid('default');
        }
        {
            /* @var $container MockObject|ContainerInterface */
            $container = $this->getMockForAbstractClass(ContainerInterface::class);
            $container->expects(static::exactly(1))
                      ->method('has')
                      ->with($key)
                      ->willReturn(false);
        }
        {
            /* @var $callback MockObject|callable */
            $callback = $this->getMockForAbstractClass(CallbackInterface::class);
            $callback->expects(static::once())
                     ->method('__invoke')
                     ->with($container)
                     ->willReturn($default);
        }

        $subject = new TestSubject($key, $callback);

        self::assertSame($default, $subject($container));
    }

    /**
     * @since [*next-version*]
     */
    public function testInvokeDefaultNull()
    {
        {
            $key = uniqid('key');
        }
        {
            /* @var $container MockObject|ContainerInterface */
            $container = $this->getMockForAbstractClass(ContainerInterface::class);
            $container->expects(static::exactly(1))
                      ->method('has')
                      ->with($key)
                      ->willReturn(false);
        }

        $subject = new TestSubject($key);

        self::assertNull($subject($container));
    }
}
