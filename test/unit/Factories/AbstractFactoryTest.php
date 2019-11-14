<?php

namespace Dhii\Modular\Module\UnitTest\Factories;

use Dhii\Modular\Module\Factories\AbstractFactory as TestSubject;
use Dhii\Modular\Module\FactoryInterface;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject as MockObject;

/**
 * @since [*next-version*]
 */
class AbstractFactoryTest extends TestCase
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

        $subject = $this->createSubject($deps);

        static::assertSame($deps, $subject->getDependencies());
    }
}
