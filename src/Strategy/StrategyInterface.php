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
     * @param FeatureInterface $Feature
     *
     * @return bool
     */
    public function handle($args);


    /**
     * Returns strategy's name.
     *
     * @return string
     */
    public function getName();
}
