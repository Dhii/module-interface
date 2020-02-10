<?php

namespace Dhii\Modular\UnitTest\Module;

use Dhii\Modular\Module\ExtensionInterface as TestSubject;
use Dhii\Modular\Module\ServiceInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * Tests {@see TestSubject}.
 *
 * @since [*next-version*]
 */
class ExtensionInterfaceTest extends TestCase
{
    /**
     * Creates a new instance of the test subject.
     *
     * @since [*next-version*]
     *
     * @return TestSubject|MockObject
     */
    public function createInstance()
    {
        return $this->getMockBuilder(TestSubject::class)->getMock();
    }

    /**
     * Tests whether a valid instance of the test subject can be created.
     *
     * @since [*next-version*]
     */
    public function testCanBeCreated()
    {
        $subject = $this->createInstance();

        $this->assertInstanceOf(TestSubject::class, $subject);
        $this->assertInstanceOf(ServiceInterface::class, $subject);
    }
}
