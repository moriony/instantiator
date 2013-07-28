<?php

namespace Moriony\Instantiator\Constructor;

interface ConstructorInterface
{
    public function create($className, $args = null);
}