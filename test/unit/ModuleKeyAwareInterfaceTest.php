<?php

namespace Dhii\Modular\UnitTest\Module;

use Dhii\Modular\Module\ModuleKeyAwareInterface;
use Xpmock\TestCase;

/**
 * Tests {@see Dhii\Modular\Module\ModuleKeyAwareInterface}.
 *
 * @since [*next-version*]
 */
class ModuleKeyAwareInterfaceTest extends TestCase
{
    /**
     * The name of the test subject.
     *
     * @since [*next-version*]
     */
    const TEST_SUBJECT_CLASSNAME = 'Dhii\\Modular\\Module\\ModuleKeyAwareInterface';

    /**
     * Creates a new instance of the test subject.
     *
     * @since [*next-version*]
     *
     * @return ModuleKeyAwareInterface
     */
    public function createInstance()
    {
        $mock = $this->mock(static::TEST_SUBJECT_CLASSNAME)
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
    }
}
