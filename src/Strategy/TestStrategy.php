<?php

namespace Humweb\Features\Strategy;

/**
 * Test strategy.
 */
class TestStrategy extends AbstractStrategy
{

    protected $name;

    /**
     * {@inheritdoc}
     */
    public function handle($args = [])
    {
        return true;
    }
}
