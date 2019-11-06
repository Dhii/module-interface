<?php

namespace Dhii\Modular\Module\Test;

use Throwable;
use Exception;
use Error;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockBuilder as MockBuilder;

/**
 * Eases development of tests by allowing creation of more complex mocks.
 *
 * The original {@see TestCase::getMockBuilder()} allows mocking only a class or an interface.
 * But sometimes, it is necessary to mock a class that implements one or more interfaces.
 * One such case is with exceptions: testing an interface that extends {@see Throwable} requires the extension
 * of {@see Exception} or {@see Error} by the mock.
 */
trait GetImplementingMockBuilderCapableTrait
{
    /**
     * Retrieves a builder for a class that extends the specified base class, while implementing the specified interfaces.
     *
     * @param string $baseClassName The name of the base class to extend.
     * @param array $interfaceNames The names of interfaces to implement
     * @return MockBuilder A builder for the new class.
     */
    public function getImplementingMockBuilder(string $baseClassName, array $interfaceNames)
    {
        $className = uniqid("{$baseClassName}_");
        $interfaceNames = implode(', ', $interfaceNames);
        $classString = "abstract class $className extends $baseClassName implements $interfaceNames {}";

        eval($classString);

        return $this->getMockBuilder($className);
    }

    /**
     * Retrieves a mock builder for the specified classname.
     *
     * @param string $className
     * @return MockBuilder The builder.
     */
    abstract public function getMockBuilder($className);
}