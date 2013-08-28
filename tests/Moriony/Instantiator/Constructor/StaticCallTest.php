<?php
namespace Moriony\Instantiator\Constructor;

class StaticCallTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var StaticCall
     */
    protected $constructor;

    public function setUp()
    {
        $this->constructor = new StaticCall('getInstance');
    }

    /**
     * @expectedException \Moriony\Instantiator\Constructor\Exception\ClassNotFound
     */
    public function testValidateClassNotFound()
    {
        $this->constructor->validate('invalid_class');
    }

    /**
     * @expectedException \Moriony\Instantiator\Constructor\Exception\MethodNotFound
     */
    public function testValidateMethodNotFound()
    {
        include_once 'AbstractClass.php';
        $this->constructor->validate('AbstractClass');
    }

    /**
     * @expectedException \Moriony\Instantiator\Constructor\Exception\NonPublicMethod
     */
    public function testValidateProtectedStaticMethod()
    {
        include_once 'ProtectedStaticMethod.php';
        $this->constructor->validate('ProtectedStaticMethod');
    }

    /**
     * @expectedException \Moriony\Instantiator\Constructor\Exception\NonStaticMethod
     */
    public function testValidateNonStaticMethod()
    {
        include_once 'PublicMethod.php';
        $this->constructor->validate('PublicMethod');
    }

    /**
     * @expectedException \Moriony\Instantiator\Constructor\Exception\MissingArgument
     */
    public function testValidateMissingArgument()
    {
        include_once 'PublicStaticMethod.php';
        $this->constructor->validate('PublicStaticMethod');
    }

    public function testCreationWithArguments()
    {
        include_once 'PublicStaticMethod.php';
        $object = $this->constructor->create('PublicStaticMethod', array('arg1', 'arg2'));
        $this->assertInstanceOf('PublicStaticMethod', $object);
    }
}