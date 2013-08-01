<?php

require_once "../vendor/autoload.php";

use Moriony\Instantiator\Factory;
use Moriony\Instantiator\Constructor\Base;
use Moriony\Instantiator\ClassName\Decorator\NamespaceDecorator;

$instantiator = new Factory(new Base, new NamespaceDecorator('Moriony\Instantiator'));

var_dump($instantiator->create('ClassName\Decorator\NoneDecorator'));





