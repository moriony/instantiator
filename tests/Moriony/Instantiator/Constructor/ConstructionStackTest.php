<?php
namespace Moriony\Instantiator\Constructor;

use Moriony\Instantiator\Constructor\Exception\UnconstructableClass;

class ConstructionStackTest extends \PHPUnit_Framework_TestCase
{
    const CONSTRUCTOR_INTERFACE = 'Moriony\Instantiator\Constructor\ConstructorInterface';
    const CONSTRUCTION_STACK = 'Moriony\Instantiator\Constructor\ConstructionStack';

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|ConstructorInterface
     */
    protected $constructor1;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|ConstructorInterface
     */
    protected $constructor2;

    public function setUp()
    {
        $this->constructor1 = $this->getMock(self::CONSTRUCTOR_INTERFACE, array('create', 'isConstructable', 'validate'));
        $this->constructor2 = $this->getMock(self::CONSTRUCTOR_INTERFACE, array('create', 'isConstructable', 'validate'));
    }

    public function testStackSetter()
    {
        /**
         * @var \PHPUnit_Framework_MockObject_MockObject|ConstructionStack $stack
         */
        $stack = $this->getMock(self::CONSTRUCTION_STACK, array('addConstructor'));
        $stack->expects($this->exactly(2))
              ->method('addConstructor');
        $stack->setStack(array($this->constructor1, $this->constructor2));
    }

    /**
     * @expectedException \Moriony\Instantiator\Constructor\Exception\EmptyConstructorStack
     */
    public function testEmptyStackValidation()
    {
        $stack = new ConstructionStack;
        $stack->validate('some_class');
    }

    /**
     * @expectedException \Moriony\Instantiator\Constructor\Exception\UnconstructableClass
     */
    public function testUnconstructableClassValidation()
    {
        $this->constructor1
             ->expects($this->once())
             ->method('isConstructable')
             ->will($this->returnValue(false));
        $this->constructor2
             ->expects($this->once())
             ->method('isConstructable')
             ->will($this->returnValue(false));
        $stack = new ConstructionStack(array($this->constructor1, $this->constructor2));
        $stack->validate('some_class');
    }

    public function testSuccessfulValidation()
    {
        $this->constructor1
            ->expects($this->once())
            ->method('isConstructable')
            ->will($this->returnValue(true));
        $this->constructor2
            ->expects($this->never())
            ->method('isConstructable');
        $stack = new ConstructionStack(array($this->constructor1, $this->constructor2));
        $this->assertTrue($stack->validate('some_class'));
    }

    public function testValidationBeforeCreation()
    {
        /**
         * @var \PHPUnit_Framework_MockObject_MockObject|ConstructionStack $stack
         */
        $stack = $this->getMock(self::CONSTRUCTION_STACK, array('onValidate'));
        $stack->expects($this->once())
              ->method('onValidate');
        $stack->create('some_class');
    }

    public function testSuccessfulCreation()
    {
        $this->constructor1
            ->expects($this->once())
            ->method('isConstructable')
            ->will($this->returnValue(true));

        $this->constructor1
            ->expects($this->once())
            ->method('create')
            ->will($this->returnValue('expected_value'));

        $stack = new ConstructionStack(array($this->constructor1, $this->constructor2));
        $this->assertEquals('expected_value', $stack->create('some_class'));
    }
}