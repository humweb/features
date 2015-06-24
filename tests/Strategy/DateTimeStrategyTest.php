<?php

namespace Humweb\Features\Tests\Strategy;

use DateTime;
use Humweb\Features\StrategyCollection;

/**
 * Test DateTimeStrategy class
 *
 * @package Humweb\Features
 */
class DateTimeStrategyTest extends \PHPUnit_Framework_TestCase
{

    protected $collection;


    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        $this->collection = new StrategyCollection();
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
    public function it_compares_date_is_less_than()
    {
        $this->assertStrategy('2012-12-10', '<', true);
        $this->assertStrategy('2100-12-10', '<', false);
    }


    /**
     * @test
     */
    public function it_compares_date_is_less_than_equals()
    {
        $this->assertStrategy('2012-12-10', '<=', true);
        $this->assertStrategy(new DateTime(), '<=', true);
        $this->assertStrategy('2100-12-12', '<=', false);
    }


    /**
     * @test
     */
    public function it_compares_date_is_greater_than_equals()
    {
        $this->assertStrategy('2100-12-12', '>=', true);
        $this->assertStrategy('2012-12-12', '>=', false);
        $this->assertStrategy(new DateTime(), '>=', true);
    }


    /**
     * @test
     */
    public function it_compares_date_is_greater_than()
    {
        $this->assertStrategy('2100-12-12', '>', true);
        $this->assertStrategy('2012-12-12', '>', false);
    }


    /**
     * @test
     */
    public function it_compares_date_is_equals()
    {
        $this->assertStrategy('2100-12-12', '==', false);
        $this->assertStrategy(new DateTime(), '==', true);
    }


    /**
     * @test
     */
    public function it_compares_date_is_not_equals()
    {
        $this->assertStrategy('2100-12-12', '!=', true);
        $this->assertStrategy(new DateTime(), '!=', false);
    }


    protected function assertStrategy($date, $operator, $expected = true)
    {
        $this->collection->addStrategy('DateTimeTest', 'DateTime', [
            'datetime' => $date,
            'operator' => $operator,
        ]);
        $this->assertEquals($expected, $this->collection->check());

        $this->collection->flush();
    }
}
