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
        $this->validate($class, $args);
        foreach ($this->stack as $constructor) {
            if ($constructor->isConstructable($class, $args)) {
                return $constructor->create($class, $args);
            }
        }
    }

    public function validate($class, array $args = array())
    {
        if (!$this->stack) {
            throw new EmptyConstructorStack;
        }
        foreach ($this->stack as $constructor) {
            if ($constructor->isConstructable($class, $args)) {
                return true;
            }
        }
        throw new UnconstructableClass(sprintf("Can't construct object of %s with current construction stack", $class));
    }
}