<?php

namespace Humweb\Features\Tests\Strategy;

use DateTime;
use Humweb\Features\Strategy\TestStrategy;
use Humweb\Features\StrategyCollection;

/**
 * Test AbstractStrategy class
 *
 * @package Humweb\Features
 */
class AbstractStrategyTest extends \PHPUnit_Framework_TestCase
{

    protected $strategy;


    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        $this->strategy = new TestStrategy();
    }


    /**
     * {@inheritdoc}
     */
    public function tearDown()
    {
        unset($this->strategy);
    }


    /**
     * @test
     */
    public function it_can_set_and_get_name()
    {
        $this->assertEquals('Test', $this->strategy->getName());

        $this->strategy->setName('Foo');
        $this->assertEquals('Foo', $this->strategy->getName());

        $this->strategy->setName();
        $this->assertEquals('Test', $this->strategy->getName());
    }

    /**
     * @test
     */
    public function it_can_handle_strategies()
    {
        $this->assertEquals(true, $this->strategy->handle());
    }
}
