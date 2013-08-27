<?php
namespace Moriony\Instantiator;

class FactoryTest extends \PHPUnit_Framework_TestCase
{
    const CONSTRUCTOR_INTERFACE = 'Moriony\Instantiator\Constructor\ConstructorInterface';
    const CLASSNAME_DECORATOR_INTERFACE = 'Moriony\Instantiator\ClassName\Decorator\DecoratorInterface';

    /**
     * @var Factory
     */
    protected $factory;
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $constructor;
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $classnameDecorator;

    public function setUp()
    {
        $this->constructor = $this->getMock(self::CONSTRUCTOR_INTERFACE, array('create', 'isConstructable', 'validate'));
        $this->classnameDecorator = $this->getMock(self::CLASSNAME_DECORATOR_INTERFACE, array('decorate'));
        $this->factory = new Factory($this->constructor, $this->classnameDecorator);
    }

    public function testConstructorObtain()
    {
        $this->assertInstanceOf(self::CONSTRUCTOR_INTERFACE, $this->factory->getConstructor());
    }

    public function testClassNameDecoratorObtain()
    {
        $this->assertInstanceOf(self::CLASSNAME_DECORATOR_INTERFACE, $this->factory->getDecorator());
    }

    public function testCreate()
    {
        $this->classnameDecorator
             ->expects($this->once())
             ->method('decorate')
             ->with('test')
             ->will($this->returnValue('test'));
        $this->constructor
             ->expects($this->once())
             ->method('create')
             ->with('test');
        $this->factory->create('test');
    }
}