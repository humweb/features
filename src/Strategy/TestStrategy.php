<?php

namespace Humweb\Features\Strategy;

/**
 * Test strategy.
 */
class TestStrategy extends AbstractStrategy
{
    /**
     * {@inheritdoc}
     */
    public function handle($Feature, array $args = [])
    {
        return;
    }
}
