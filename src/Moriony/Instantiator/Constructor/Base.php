<?php

namespace Moriony\Instantiator\Constructor;

use Moriony\Instantiator\Constructor\Exception\AbstractClass;
use Moriony\Instantiator\Constructor\Exception\ClassNotFound;
use Moriony\Instantiator\Constructor\Exception\MissingArgument;
use Moriony\Instantiator\Constructor\Exception\NonPublicMethod;

class Base extends AbstractConstructor implements ConstructorInterface
{
    public function create($class, array $args = array())
    {
        $reflection = new \ReflectionClass($class);
        if ($reflection->getConstructor()) {
            $object = $reflection->newInstanceArgs($args);
        } else {
            $object = $reflection->newInstanceArgs();
        }
        return $object;
    }

    public function validate($class, array $args = array())
    {
        if (!class_exists($class)) {
            throw new ClassNotFound(sprintf("Class %s not found", $class));
        }
        $reflection = new \ReflectionClass($class);
        if($reflection->isAbstract()) {
            throw new AbstractClass(sprintf('Class %s is abstract', $class));
        }
        if($constructor = $reflection->getConstructor()) {
            if (!$constructor->isPublic()) {
                throw new NonPublicMethod("Non public constructor");
            }
            $expected = $constructor->getNumberOfRequiredParameters();
            $received = count($args);
            if ($constructor->getNumberOfRequiredParameters() > count($args)) {
                throw new MissingArgument(sprintf("Expected %d arguments but %d received", $expected, $received));
            }
        }
    }
}