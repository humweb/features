<?php

namespace Humweb\Features\Tests;

use Humweb\Features\Features;
use Humweb\Features\StrategyCollection;

/**
 * Test Features class.
 */
class FeaturesTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Features
     */
    protected $features;


    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        $this->features = new Features();

        $this->features->create('testFeature', 'Feature test collection', [
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
    public function it_has_test_feature()
    {

        $expected = true;

        $actual = $this->features->exists('testFeature');

        $this->assertEquals($expected, $actual);
    }


    /**
     * @test
     */
    public function it_can_check_closure_features()
    {
        $this->features->flush();
        $this->features->create('testClosure')->add('closureTrue', function () {
            return true;
        });

        $this->assertEquals(true, $this->features->isEnabled('testClosure'));
    }


    /**
     * @test
     */
    public function it_can_check_for_enabled_feature_closures()
    {
        $this->features->flush();

        // Threshold:2 True: 2 False: 1
        $this->features
            ->create('testFeature')
            ->add('test1', function () {
                return true;
            })
            ->add('test2', 'UserAgent', ['patterns' => ['/foo$/', '/^bar/']])
            ->setThreshold(2);

        $_SERVER['HTTP_USER_AGENT'] = 'foo';
        $this->assertEquals(true, $this->features->isEnabled('testFeature'));

        // Threshold:3 True: 2 False: 1
        $this->features->getCollection('testFeature')->add('test13', function () {
            return false;
        })->setThreshold(3);

        $this->assertEquals(false, $this->features->isEnabled('testFeature'));

        // Threshold:2 True: 2 False: 1
        $this->features->getCollection('testFeature')->setThreshold(2);
        $this->assertEquals(true, $this->features->isEnabled('testFeature'));
    }

}
