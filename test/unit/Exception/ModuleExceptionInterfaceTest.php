<?php

namespace Dhii\Modular\UnitTest\Exception;

use Dhii\Modular\Module\Exception\ModuleExceptionInterface as TestSubject;
use Dhii\Modular\Module\ModuleAwareInterface;
use Dhii\Modular\Module\Test\GetImplementingMockBuilderCapableTrait;
use Exception;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * Tests {@see TestSubject}.
 *
 * @since [*next-version*]
 */
class ModuleExceptionInterfaceTest extends TestCase
{
    use GetImplementingMockBuilderCapableTrait;

    /**
     * Creates a new instance of the test subject.
     *
     * @since [*next-version*]
     *
     * @return TestSubject&MockObject
     */
    public function createInstance()
    {
        $mock = $this->getImplementingMockBuilder(Exception::class, [TestSubject::class])
            ->setMethods([])
            ->getMock();

        return $mock;
    }

    /**
     * Tests whether a valid instance of the test subject can be created.
     *
     * @since [*next-version*]
     */
    public function testCanBeCreated()
    {
        $subject = $this->createInstance();

        $this->assertInstanceOf(
            TestSubject::class,
            $subject,
            'A valid instance of the test subject could not be created'
        );

        $this->assertInstanceOf(
            ModuleAwareInterface::class,
            $subject,
            'Subject does not implement required interface'
        );
    }
}
