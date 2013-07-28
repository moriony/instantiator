<?php

require_once "../vendor/autoload.php";

use Moriony\Instantiator\InstancePool;
use Moriony\Instantiator\Constructor\Base;
use Moriony\Instantiator\ClassName\Decorator\NamespaceDecorator;

$instantiator = new InstancePool(new Base, new NamespaceDecorator('Moriony\Instantiator'));

var_dump($instantiator->get('ClassName\Decorator\NoneDecorator'));





