<?php
namespace Moriony\Instantiator\Constructor;

use Moriony\Instantiator\Constructor\Exception\Basic;

class AbstractConstructorTest extends \PHPUnit_Framework_TestCase
{
    const ABSTRACT_CONSTRUCTOR_CLASS = 'Moriony\Instantiator\Constructor\AbstractConstructor';

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|AbstractConstructor
     */
    protected $constructor;

    public function setUp()
    {
        $this->constructor = $this->getMock(self::ABSTRACT_CONSTRUCTOR_CLASS, array('create', 'validate'));
    }

    public function testSuccessfulConstructableCheck()
    {
        $this->constructor
             ->expects($this->once())
             ->method('validate')
             ->with('Test', array('test1', 'test2'))
             ->will($this->returnValue(true));

        $this->assertTrue($this->constructor->isConstructable('Test', array('test1', 'test2')));
    }

    public function testFailureConstructableCheck()
    {
        $this->constructor
            ->expects($this->once())
            ->method('validate')
            ->will($this->throwException(new Basic()));

        $this->assertFalse($this->constructor->isConstructable('Test'));
    }
}