<?php

namespace Moriony\Instantiator\ClassName\Decorator;

class NoneDecorator extends AbstractDecorator implements DecoratorInterface
{
    public function decorate($className)
    {
        return $this->filter($className);
    }
}