<?php

namespace Moriony\Instantiator\ClassName\Decorator;

class NamespaceDecorator extends AbstractDecorator implements DecoratorInterface
{
    protected $namespace;

    public function __construct($namespace)
    {
        $this->namespace = $this->filter($namespace);
    }

    public function decorate($className)
    {
        $className = $this->filter($className);
        return sprintf('\%s\%s', $this->namespace, $className);
    }
}