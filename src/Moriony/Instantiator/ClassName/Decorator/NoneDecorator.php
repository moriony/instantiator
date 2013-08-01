<?php

namespace Moriony\Instantiator\ClassName\Decorator;

class NoneDecorator implements DecoratorInterface
{
    protected function filter($string)
    {
        return trim($string, " \\");
    }

    public function decorate($className)
    {
        return $this->filter($className);
    }
}