<?php
namespace Moriony\Instantiator\ClassName\Decorator;

class NamespaceDecoratorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var NamespaceDecorator
     */
    protected $decorator;

    public function setUp()
    {
        $this->decorator = new NamespaceDecorator('Namespace');
    }

    public function testDecorate()
    {
        $this->assertEquals('\Namespace\ClassName', $this->decorator->decorate('ClassName'));
    }
}