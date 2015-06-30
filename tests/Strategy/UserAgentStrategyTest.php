<?php

namespace Humweb\Features\Tests\Strategy;

use DateTime;
use Humweb\Features\StrategyCollection;

/**
 * Test UserAgentStrategy class
 *
 * @package Humweb\Features
 */
class UserAgentStrategyTest extends \PHPUnit_Framework_TestCase
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
    public function it_can_detect_and_handle_user_agent()
    {

        $this->collection->flush();

        $this->collection->addStrategy('DayTest', 'UserAgent', ['patterns' => ['/foo$/', '/^bar/']]);

        $_SERVER['HTTP_USER_AGENT'] = 'foo';
        $this->assertEquals(true, $this->collection->check('DayTest'));

        $_SERVER['HTTP_USER_AGENT'] = 'baz';
        $this->assertEquals(false, $this->collection->check('DayTest'));
    }

}
