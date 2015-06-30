<?php

namespace Humweb\Features\Tests\Strategy;

use DateTime;
use Humweb\Features\StrategyCollection;

/**
 * Test DateTimeRangeStrategy class
 *
 * @package Humweb\Features
 */
class DateTimeRangeStrategyTest extends \PHPUnit_Framework_TestCase
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
    public function it_compares_date_is_within_range()
    {
        $this->assertStrategy(['2012-12-10', '2100-12-10'], true);

        $this->assertStrategy(['2100-11-10', '2100-12-10'], false);

        // Not Strict
        $this->assertStrategy([new DateTime(), '2100-12-10'], true, false);
    }


    protected function assertStrategy($range = [], $expected = true, $strict = true)
    {
        $this->collection->add('DateTimeRangeTest', 'DateTimeRange', [
            'strict' => $strict,
            'start'     => $range[0],
            'end'       => $range[1]
        ]);
        $this->assertEquals($expected, $this->collection->check());

        $this->collection->flush();
    }
}