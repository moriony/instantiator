<?php

namespace Moriony\Instantiator\ClassName\Decorator;

class AbstractDecorator
{
    protected function filter($string)
    {
        return trim($string, " \\");
    }
}