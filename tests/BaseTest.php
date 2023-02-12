<?php

namespace Tests;

use PHPUnit\Framework\TestCase;

class BaseTest extends TestCase
{
    /**
     * @param object $object
     * @param string $methodName
     *
     * @return \ReflectionMethod
     *
     * @throws \ReflectionException
     */
    protected function getPrivateMethod(object $object, string $methodName): \ReflectionMethod
    {
        $class = new \ReflectionClass($object);
        $method = $class->getMethod($methodName);
        $method->setAccessible(true);
        return $method;
    }
}