<?php

namespace Humweb\Features\Tests;

use Humweb\Features\StrategyCollection;

/**
 * Test StrategyCollection class.
 */
class StrategyCollectionTest extends \PHPUnit_Framework_TestCase
{

    protected $collection;


    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        $this->collection = new StrategyCollection([
            'DataTime' => [
                'class' => 'DataTime'
            ]
        ]);
    }


    /**
     * {@inheritdoc}
     */
    public function tearDown()
    {
        unset($this->collection);
    }


    /**
     * @test
     */
    public function it_returns_true_when_offset_exists()
    {

        $expected = true;

        $actual = isset($this->collection['DataTime']);

        $this->assertEquals($expected, $actual);
    }


    /**
     * @test
     */
    public function i_can_add_a_single_strategy()
    {

        $expected = true;

        $this->collection->add('test1', function () {
        });
        $actual = is_callable($this->collection['test1']['class']);
        $this->assertEquals($expected, $actual);

        $this->collection->add('test2', 'UserAgent', []);
        $actual = $this->collection['test2']['class'];
        $this->assertEquals('\Humweb\Features\Strategy\UserAgentStrategy', $actual);
    }


    /**
     * @test
     */
    public function it_can_check_for_enabled_feature_closures()
    {
        $this->collection = new StrategyCollection();
        $expected = true;

        $this->collection->add('test1', function () {
            return true;
        });
        $actual = $this->collection->check();
        $this->assertEquals($expected, $actual);

        $_SERVER['HTTP_USER_AGENT'] = 'foo';
        $this->collection->setThreshold(2);
        $this->collection->add('test2', 'UserAgent', [
            'patterns' => ['/foo$/', '/^bar/']
        ]);
        $actual = $this->collection->check();
        $this->assertEquals($expected, $actual);

        $this->collection->setThreshold(3);
        $this->collection->add('test13', function () {
            return false;
        });
        $actual = $this->collection->check();
        $this->assertEquals(false, $actual);
    }


    /**
     * @test
     */
    public function i_can_toggle_feature_status()
    {
        $this->collection->setThreshold(1)->flush();

        $this->collection->add('test1', function () {
            return true;
        });
        $this->assertEquals(true, $this->collection->check());

        $this->collection->off();
        $this->assertEquals(false, $this->collection->check());

        $this->collection->on();
        $this->assertEquals(true, $this->collection->check());
    }
}
