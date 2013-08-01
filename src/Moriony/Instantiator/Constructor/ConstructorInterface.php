<?php

namespace Moriony\Instantiator\Constructor;

interface ConstructorInterface
{
    public function create($class, array $args = array());
    public function isConstructable($class, array $args = array());
    public function validate($class, array $args = array());
}