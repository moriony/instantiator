<?php

namespace Moriony\Instantiator\ClassName\Decorator;

class NamespaceDecorator implements DecoratorInterface
{
    protected $namespace;

    public function __construct($namespace)
    {
        $this->namespace = $this->filter($namespace);
    }

    protected function filter($string)
{
    return trim($string, " \\");
}

    public function decorate($className)
    {
        $className = $this->filter($className);
        return sprintf('\%s\%s', $this->namespace, $className);
    }
}