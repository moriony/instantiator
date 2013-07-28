<?php

namespace Moriony\Instantiator\ClassName\Decorator;

class NoneDecorator implements DecoratorInterface
{
    public function decorate($className)
    {
        return $className;
    }
}