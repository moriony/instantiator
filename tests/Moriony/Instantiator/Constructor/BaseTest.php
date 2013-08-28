<?php
namespace Moriony\Instantiator\Constructor;

class BaseTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Base
     */
    protected $constructor;

    public function setUp()
    {
        $this->constructor = new Base;
    }

    /**
     * @expectedException \Moriony\Instantiator\Constructor\Exception\ClassNotFound
     */
    public function testValidateClassNotFound()
    {
        $this->constructor->validate('invalid_class');
    }

    /**
     * @expectedException \Moriony\Instantiator\Constructor\Exception\AbstractClass
     */
    public function testValidateAbstractClass()
    {
        include_once 'AbstractClass.php';
        $this->constructor->validate('AbstractClass');
    }

    /**
     * @expectedException \Moriony\Instantiator\Constructor\Exception\NonPublicMethod
     */
    public function testValidateNonPublicConstructorClass()
    {
        include_once 'NonPublicConstructorClass.php';
        $this->constructor->validate('NonPublicConstructorClass');
    }

    /**
     * @expectedException \Moriony\Instantiator\Constructor\Exception\MissingArgument
     */
    public function testValidateMissingArgument()
    {
        include_once 'ClassWithArguments.php';
        $this->constructor->validate('ClassWithArguments');
    }

    public function testCreationWithArguments()
    {
        include_once 'ClassWithArguments.php';
        $object = $this->constructor->create('ClassWithArguments', array('arg1', 'arg2'));
        $this->assertInstanceOf('ClassWithArguments', $object);
    }

    public function testCreationWithoutConstructor()
    {
        include_once 'ClassWithoutConstructor.php';
        $object = $this->constructor->create('ClassWithoutConstructor', array('arg1', 'arg2'));
        $this->assertInstanceOf('ClassWithoutConstructor', $object);
    }

}