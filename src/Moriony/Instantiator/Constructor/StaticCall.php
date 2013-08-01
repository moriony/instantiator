<?php

namespace Moriony\Instantiator\Constructor;

use Moriony\Instantiator\Constructor\Exception\ClassNotFound;
use Moriony\Instantiator\Constructor\Exception\MethodNotFound;
use Moriony\Instantiator\Constructor\Exception\MissingArgument;
use Moriony\Instantiator\Constructor\Exception\NonPublicMethod;
use Moriony\Instantiator\Constructor\Exception\NonStaticMethod;

class StaticCall extends AbstractConstructor implements ConstructorInterface
{
    protected $method;

    public function __construct($method)
    {
        $this->method = trim($method);
    }

    public function create($class, array $args = array())
    {
        $this->validate($class, $args);
        return call_user_func_array(array($class, $this->method), $args);
    }

    public function validate($class, array $args = array())
    {
        if (!class_exists($class)) {
            throw new ClassNotFound(sprintf("Class %s not found", $class));
        }
        $reflection = new \ReflectionClass($class);
        if (!$reflection->hasMethod($this->method)) {
            throw new MethodNotFound(sprintf("Method %s not found", $this->method));
        }

        $method = $reflection->getMethod($this->method);
        if (!$method->isPublic()) {
            throw new NonPublicMethod;
        }

        if (!$method->isStatic()) {
            throw new NonStaticMethod;
        }

        $expected = $method->getNumberOfRequiredParameters();
        $received = count($args);
        if ($method->getNumberOfRequiredParameters() > count($args)) {
            throw new MissingArgument(sprintf("Expected %d arguments but %d received", $expected, $received));
        }
    }
}