<?php
namespace Moriony\Instantiator\ClassName\Decorator;

class NoneDecoratorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var NoneDecorator
     */
    protected $decorator;

    public function setUp()
    {
        $this->decorator = new NoneDecorator('ClassName');
    }

    public function testDecorate()
    {
        $this->assertEquals('ClassName', $this->decorator->decorate('ClassName'));
    }
}