<?php

namespace Dhii\Modular\Module\UnitTest\Exception;

use Dhii\Modular\Module\Exception\ModuleException as TestSubject;
use Dhii\Modular\Module\ModuleInterface;
use Exception;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use Throwable;

/**
 * Tests {@link \Dhii\Modular\Module\Exception\ModuleException}.
 *
 * @since [*next-version*]
 */
class ModuleExceptionTest extends TestCase
{
    /**
     * @since [*next-version*]
     */
    public function testConstruct()
    {
        $subject = new TestSubject();

        static::assertInstanceOf(Throwable::class, $subject);
    }

    /**
     * @since [*next-version*]
     *
     * @throws TestSubject
     */
    public function testCanBeThrown()
    {
        $this->expectException(TestSubject::class);

        throw new TestSubject();
    }

    /**
     * @since [*next-version*]
     */
    public function testGetMessage()
    {
        $message = uniqid('message');
        $subject = new TestSubject($message);

        static::assertSame($message, $subject->getMessage());
    }

    /**
     * @since [*next-version*]
     */
    public function testGetCode()
    {
        $code = rand(0, 10000);
        $subject = new TestSubject('', $code);

        static::assertSame($code, $subject->getCode());
    }

    /**
     * @since [*next-version*]
     */
    public function testGetPrevious()
    {
        /* @var $previous Throwable|MockObject */
        $previous = $this->getMockForAbstractClass(Exception::class);
        $subject = new TestSubject('', 0, $previous);

        static::assertSame($previous, $subject->getPrevious());
    }

    /**
     * @since [*next-version*]
     */
    public function testGetModule()
    {
        /* @var $module ModuleInterface|MockObject */
        $module = $this->getMockForAbstractClass(ModuleInterface::class);
        $subject = new TestSubject('', 0, null, $module);

        static::assertSame($module, $subject->getModule());
    }
}
