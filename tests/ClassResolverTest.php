<?php

namespace Humweb\Features\Tests;

use Humweb\Features\Resolvers\ClassResolver;

/**
 * Test ClassResolver class.
 *
 * @package Humweb\Features\Resolvers\ClassResolver
 */
class ClassResolverTest extends \PHPUnit_Framework_TestCase
{

    protected $resolver;


    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        $this->resolver = new ClassResolver();
        $this->resolver->setNamespace('Humweb\\Features\\Strategy')->setSuffix('Strategy');
    }


    /**
     * {@inheritdoc}
     */
    public function tearDown()
    {
        unset($this->resolver);
    }


    /**
     * @test
     * @covers ::resolve
     */
    public function is_resolves_class_from_default_namespace()
    {
        $expected = '\\'.$this->resolver->getNamespace().'\\DateTimeStrategy';

        $actual = $this->resolver->resolve('DateTime');

        $this->assertEquals($expected, $actual);
    }


    /**
     * @test
     * @covers ::resolve
     */
    public function is_resolves_class_will_full_namespace()
    {
        $expected = 'Humweb\Features\Strategy\DateTimeStrategy';

        $actual = $this->resolver->resolve('Humweb\Features\Strategy\DateTimeStrategy');

        $this->assertEquals($expected, $actual);
    }


    /**
     * @test
     */
    public function is_throws_exception_when_unresolved()
    {
        $this->setExpectedException('InvalidArgumentException');

        $this->resolver->resolve('App\Foo\Bar\Baz');
    }

}
