<?php

namespace Humweb\Features\Tests;

use Humweb\Features\Strategy\TestStrategy;
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
            'DateTime' => ['DateTime']
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

        $actual = isset($this->collection['DateTime']);

        $this->assertEquals($expected, $actual);
    }


    /**
     * @test
     */
    public function i_can_add_a_single_strategy()
    {

        $expected = true;

        $this->collection->add('test1', function () {});
        $actual = is_callable($this->collection['test1']['class']);
        $this->assertEquals($expected, $actual);

        $this->collection->add('test2', 'UserAgent', []);
        $actual = $this->collection['test2']['class'];
        $this->assertEquals('\Humweb\Features\Strategy\UserAgentStrategy', $actual);
    }


    /**
     * @test
     */
    public function i_can_add_multiple_strategies_at_once()
    {
        $this->collection->flush();

        $this->assertFalse(isset($this->collection['test1']));
        $this->assertFalse(isset($this->collection['test2']));

        $this->collection->add([
            'test1' => ['DateTime'],
            'test2' => ['UserAgent']
        ]);


        $this->assertTrue(isset($this->collection['test1']));
        $this->assertTrue(isset($this->collection['test2']));
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
    public function i_can_add_strategy_instance()
    {
        $this->collection->flush();

        $instance = new TestStrategy();
        $this->collection->add('test1', $instance);
        $this->assertEquals(true,  $this->collection->check());

    }
    /**
     * @test
     */
    public function i_throws_exception_when_class_is_not_a_string_or_callable()
    {
        $this->collection->setThreshold(1)->flush();

        $this->setExpectedException('InvalidArgumentException');
        $this->collection->add('test1', 123);

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
        $this->assertEquals(0, $this->collection->getStatus());

        $this->collection->on();
        $this->assertEquals(true, $this->collection->check());
        $this->assertEquals(1, $this->collection->getStatus());
    }


    /**
     * @test
     */
    public function i_can_unset_by_array_offset()
    {
        $this->collection->flush();
        $this->collection['test1'] = ['DateTime'];
        $this->assertTrue(isset($this->collection['test1']));

        $this->assertEquals(1, $this->collection->count());

        unset($this->collection['test1']);

        $this->assertEquals(0, $this->collection->count());
        $this->assertFalse(isset($this->collection['test1']));
    }


    /**
     * @test
     */
    public function i_can_set_threshold()
    {
        $this->collection->flush();
        $this->collection->setThreshold(3);
        $this->assertEquals(3, $this->collection->getThreshold());

        $this->collection->setThreshold(2);
        $this->assertEquals(2, $this->collection->getThreshold());
    }


    /**
     * @test
     */
    public function i_can_get_status()
    {
        $this->collection->flush();
        $this->assertEquals(0, count($this->collection->getStrategies()));
        $this->collection['test1'] = ['DateTime'];
        $this->assertEquals(1, count($this->collection->getStrategies()));
    }

    /**
     * @test
     */
    public function i_can_get_strategies_array()
    {
        $this->collection->flush();
        $this->assertEquals(0, count($this->collection->getStrategies()));
        $this->collection['test1'] = ['DateTime'];
        $this->assertEquals(1, count($this->collection->getStrategies()));
    }


}
