<?php

require_once "../vendor/autoload.php";

use Moriony\Instantiator\Factory;
use Moriony\Instantiator\Constructor\StaticCall;
use Moriony\Instantiator\ClassName\Decorator\NoneDecorator;

class Example
{
    public static function getInstance()
    {
        return new self;
    }
}

$instantiator = new Factory(new StaticCall('getInstance'), new NoneDecorator);

var_dump($instantiator->create('Example'));





