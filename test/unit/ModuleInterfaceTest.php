<?php

namespace Dhii\Modular\UnitTest\Module;

use Dhii\Modular\Module\ModuleInterface;
use Xpmock\TestCase;

/**
 * Tests {@see Dhii\Modular\Module\ModuleInterface}.
 *
 * @since [*next-version*]
 */
class ModuleInterfaceTest extends TestCase
{
    /**
     * The name of the test subject.
     *
     * @since [*next-version*]
     */
    const TEST_SUBJECT_CLASSNAME = 'Dhii\\Modular\\Module\\ModuleInterface';

    /**
     * Creates a new instance of the test subject.
     *
     * @since [*next-version*]
     *
     * @return ModuleInterface
     */
    public function createInstance()
    {
        $mock = $this->mock(static::TEST_SUBJECT_CLASSNAME)
            ->getKey()
            ->load()
            ->new();

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
            static::TEST_SUBJECT_CLASSNAME,
            $subject,
            'A valid instance of the test subject could not be created'
        );

        $this->assertInstanceOf(
            'Dhii\\Data\\KeyAwareInterface',
            $subject,
            'Subject does not implement a required interface'
        );
    }
}
