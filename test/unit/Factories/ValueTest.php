<?php

namespace Dhii\Modular\Module\UnitTest\Factories;

use Dhii\Modular\Module\Factories\Value as TestSubject;
use Dhii\Modular\Module\FactoryInterface;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use Psr\Container\ContainerInterface;

/**
 * ValueTest
 *
 * @since [*next-version*]
 */
class ValueTest extends TestCase
{
    /**
     * @since [*next-version*]
     */
    public function testConstruct()
    {
        $subject = new TestSubject(0);

        static::assertInstanceOf(FactoryInterface::class, $subject);
    }

    /**
     * @since [*next-version*]
     */
    public function testInvoke()
    {
        $value = uniqid('value');
        $subject = new TestSubject($value);

        /* @var $container MockObject|ContainerInterface */
        $container = $this->getMockForAbstractClass(ContainerInterface::class);

        static::assertSame($value, $subject($container));
    }
}
