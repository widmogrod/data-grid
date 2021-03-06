<?php
namespace DataGridTest\Adapter;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.0 on 2012-11-17 at 11:53:23.
 */
class ArrayObject extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \DataGrid\Adapter\ArrayObject
     */
    protected $object1;

    /**
     * @var \DataGrid\Adapter\ArrayObject
     */
    protected $object2;

    /**
     * @var array
     */
    protected $adaptable1 = array(
        array('user' => 'widmogrod'),
        array('user' => 'widmogrod2'),
        array('user' => 'widmogrod3'),
    );

    protected $adaptable2;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->adaptable2 = new \ArrayObject($this->adaptable1);
        $this->object1 = new \DataGrid\Adapter\ArrayObject($this->adaptable1);
        $this->object2 = new \DataGrid\Adapter\ArrayObject($this->adaptable2);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

    public function testInstanceOf()
    {
        $this->assertInstanceOf('DataGrid\Adapter\ArrayObject', $this->object1);
        $this->assertInstanceOf('DataGrid\Adapter\ArrayObject', $this->object2);
    }

    public function testAdaptable()
    {
        $this->assertEquals($this->adaptable1, $this->object1->getAdaptable());
        $this->assertEquals($this->adaptable2, $this->object2->getAdaptable());
    }

    public function testToArray()
    {
        $this->assertEquals($this->adaptable1, $this->object1->toArray());
        $this->assertEquals($this->adaptable2->getArrayCopy(), $this->object2->toArray());
    }

    public function testFetchData() {
        $this->assertNull($this->object1->fetchData());
        $this->assertNull($this->object2->fetchData());
    }
}