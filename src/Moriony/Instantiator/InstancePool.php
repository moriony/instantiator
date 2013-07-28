<?php

namespace Moriony\Instantiator;

use Moriony\Instantiator\ClassName\Decorator\DecoratorInterface;
use Moriony\Instantiator\Constructor\ConstructorInterface;

class InstancePool
{
    protected $constructor;
    protected $decorator;
    protected $objects = array();

    public function __construct(ConstructorInterface $constructor, DecoratorInterface $decorator)
    {
        $this->constructor = $constructor;
        $this->decorator = $decorator;
    }

    public function get($className, $args = array())
    {
        $className = $this->decorator->decorate($className);
        if(!array_key_exists($className, $this->objects)) {
            $this->objects[$className] = $this->constructor->create($className, $args);
        }
        return $this->objects[$className];
    }
}