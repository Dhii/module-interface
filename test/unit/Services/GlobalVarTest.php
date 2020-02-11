<?php

namespace Dhii\Modular\Module\UnitTest\Services;

use Dhii\Modular\Module\Services\GlobalVar as TestSubject;
use Dhii\Modular\Module\FactoryInterface;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use Psr\Container\ContainerInterface;

/**
 * @since [*next-version*]
 */
class GlobalVarTest extends TestCase
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
        global $testGlobalVar;
        $testGlobalVar = uniqid('test-value');

        $subject = new TestSubject('testGlobalVar');

        /* @var $container MockObject|ContainerInterface */
        $container = $this->getMockForAbstractClass(ContainerInterface::class);

        static::assertSame($testGlobalVar, $subject($container));
    }
}
