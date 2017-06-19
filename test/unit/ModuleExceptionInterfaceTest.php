<?php

namespace Dhii\Modular\UnitTest\Module;

use Dhii\Modular\Module\ModuleExceptionInterface;
use Xpmock\TestCase;

/**
 * Tests {@see Dhii\Modular\Module\ModuleExceptionInterface}.
 *
 * @since [*next-version*]
 */
class ModuleExceptionInterfaceTest extends TestCase
{
    /**
     * The name of the test subject.
     *
     * @since [*next-version*]
     */
    const TEST_SUBJECT_CLASSNAME = 'Dhii\\Modular\\Module\\ModuleExceptionInterface';

    /**
     * Creates a new instance of the test subject.
     *
     * @since [*next-version*]
     *
     * @return ModuleExceptionInterface
     */
    public function createInstance()
    {
        $mock = $this->mock(static::TEST_SUBJECT_CLASSNAME)
            ->getModule()
            ->getModuleKey()
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
            'Dhii\\Modular\\Module\\ModuleAwareInterface',
            $subject,
            'Subject does not implement required interface'
        );
        $this->assertInstanceOf(
            'Dhii\\Modular\\Module\\ModuleKeyAwareInterface',
            $subject,
            'Subject does not implement required interface'
        );
    }
}
