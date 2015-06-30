<?php

namespace Humweb\Features\Tests\Strategy;

use DateTime;
use Humweb\Features\StrategyCollection;

/**
 * Test DaysOfWeekStrategy class
 *
 * @package Humweb\Features
 */
class DaysOfWeekStrategyTest extends \PHPUnit_Framework_TestCase
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
    public function it_can_detect_a_single_day()
    {
        $this->collection->addStrategy('DayTest', 'days-of-week', [
            'days' => [(new DateTime())->format('D')]
        ]);
        $this->assertEquals(true, $this->collection->check());

        $this->collection->flush();
    }


    /**
     * @test
     */
    public function it_can_detect_multiple_days()
    {

        $this->collection->addStrategy('DayTest', 'DaysOfWeek', [
            'days' => [$this->getDayOtherThanToday(), (new DateTime())->format('D')]
        ]);

        $this->assertEquals(true, $this->collection->check());

        $this->collection->flush();
    }


    /**
     * @test
     */
    public function it_fails_when_no_days_match()
    {

        $this->collection->addStrategy('DayTest', 'DaysOfWeek', [
            'days' => [$this->getDayOtherThanToday(), $this->getDayOtherThanToday()]
        ]);
        $this->assertEquals(false, $this->collection->check());

        $this->collection->flush();
    }


    protected function getDayOtherThanToday()
    {
        $days  = ['Mon', 'Tue', 'Wed', 'Fri', 'Sat', 'Sun'];
        $today = (new DateTime())->format('D');

        foreach ($days as $day) {
            if ($day !== $today) {
                return $day;
            }
        }
    }
}
