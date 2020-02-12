<?php

namespace Mecha\Modular\UnitTest\Services;

use Mecha\Modular\ServiceInterface;
use Mecha\Modular\Services\AbstractService as TestSubject;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject as MockObject;

/**
 * @since [*next-version*]
 */
class AbstractServiceTest extends TestCase
{
    /**
     * Creates an instance of the test subject.
     *
     * @since [*next-version*]
     *
     * @param array $deps The dependency keys.
     *
     * @return MockObject|TestSubject
     */
    public function createSubject(array $deps = [])
    {
        return $this->getMockBuilder(TestSubject::class)
                    ->setConstructorArgs([$deps])
                    ->getMockForAbstractClass();
    }

    /**
     * @since [*next-version*]
     */
    public function testConstruct()
    {
        $subject = $this->createSubject();

        static::assertInstanceOf(ServiceInterface::class, $subject);
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

        $subject = $this->createSubject($deps);

        static::assertSame($deps, $subject->getDependencies());
    }
}
