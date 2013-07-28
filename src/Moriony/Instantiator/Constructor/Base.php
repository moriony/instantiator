<?php

namespace Moriony\Instantiator\Constructor;

class Base implements ConstructorInterface
{
    public function prepareClassName($className)
    {
        $className = trim($className, " \\");
        return sprintf('\%s', $className);
    }

    public function create($className, $args = null)
    {
        $class = $this->prepareClassName($className);
        $reflection = new \ReflectionClass($class);
        if ($reflection->getConstructor()) {
            $object = $reflection->newInstanceArgs($args);
        } else {
            $object = $reflection->newInstanceArgs();
        }
        return $object;
    }
}