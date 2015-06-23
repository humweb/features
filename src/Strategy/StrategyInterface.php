<?php

namespace Humweb\Features\Strategy;

/**
 * Strategy interface.
 */
interface StrategyInterface
{
    /**
     * Tells if strategy passes or not.
     *
     * @param array $args
     *
     * @return bool
     */
    public function handle($args);


    /**
     * Returns strategy name
     *
     * @return string
     */
    public function getName();


    /**
     * Sets the strategy's name.
     *
     * @param string $name Strategy name
     */
    public function setName($name);
}
