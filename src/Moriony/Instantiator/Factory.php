<?php

namespace Moriony\Instantiator;

use Moriony\Instantiator\ClassName\Decorator\DecoratorInterface;
use Moriony\Instantiator\Constructor\ConstructorInterface;

class Factory
{
    protected $constructor;
    protected $decorator;
    protected $objects = array();

    public function __construct(ConstructorInterface $constructor, DecoratorInterface $decorator)
    {
        $this->constructor = $constructor;
        $this->decorator = $decorator;
    }

    public function create($className, $args = array())
    {
        $className = $this->decorator->decorate($className);
        return $this->constructor->create($className, $args);
    }
}