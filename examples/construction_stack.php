<?php

require_once "../vendor/autoload.php";

use Moriony\Instantiator\Factory;
use Moriony\Instantiator\Constructor\StaticCall;
use Moriony\Instantiator\Constructor\ConstructionStack;
use Moriony\Instantiator\ClassName\Decorator\NoneDecorator;

class Example
{
    public static function getInstance()
    {
        echo 123;
        return new self;
    }
}

$constructroStack = new ConstructionStack(array(
    new StaticCall('invalidMethod'),
    new StaticCall('getInstance'),
));

$instantiator = new Factory($constructorStack, new NoneDecorator);

var_dump($instantiator->create('Example'));





