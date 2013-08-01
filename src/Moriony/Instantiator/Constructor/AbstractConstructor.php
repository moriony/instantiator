<?php

namespace Moriony\Instantiator\Constructor;

use Moriony\Instantiator\Constructor\Exception\Basic;

abstract class AbstractConstructor implements ConstructorInterface
{
    public function isConstructable($class, array $args = array())
    {
        $result = true;
        try {
            $this->validate($class, $args);
        } catch(Basic $e) {
            $result = false;
        }
        return $result;
    }
}