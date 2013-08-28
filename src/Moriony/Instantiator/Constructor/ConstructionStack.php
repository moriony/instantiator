<?php

namespace Moriony\Instantiator\Constructor;

use Moriony\Instantiator\Constructor\Exception\EmptyConstructorStack;
use Moriony\Instantiator\Constructor\Exception\UnconstructableClass;

class ConstructionStack extends AbstractConstructor implements ConstructorInterface
{
    /**
     * @var ConstructorInterface[]
     */
    protected $stack;

    public function __construct(array $stack = array())
    {
        $this->setStack($stack);
    }

    public function setStack(array $stack)
    {
        foreach($stack as $constructor) {
            $this->addConstructor($constructor);
        }
        return $this;
    }

    public function addConstructor(ConstructorInterface $constructor)
    {
        $this->stack[] = $constructor;
        return $this;
    }

    public function create($class, array $args = array())
    {
        return $this->onValidate($class, $args, function($constructor, $class, $args) {
            /**
             * @var ConstructorInterface $constructor
             */
            return $constructor->create($class, $args);
        });
    }

    public function validate($class, array $args = array())
    {
        return $this->onValidate($class, $args, function() {
            return true;
        });
    }

    protected function onValidate($class, array $args = array(), \Closure $callback)
    {
        if (!$this->stack) {
            throw new EmptyConstructorStack;
        }
        foreach ($this->stack as $constructor) {
            if ($constructor->isConstructable($class, $args)) {
                return $callback($constructor, $class, $args);
            }
        }
        throw new UnconstructableClass(sprintf("Can't construct object of %s with current construction stack", $class));
    }
}