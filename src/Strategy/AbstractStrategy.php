<?php

namespace Humweb\Features\Strategy;

/**
 * Abstract strategy.
 */
abstract class AbstractStrategy implements StrategyInterface
{
    /**
     * Strategy's name.
     *
     * @var string
     */
    protected $name;


    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        if (empty($this->name)) {
            $this->setName();
        }

        return $this->name;
    }


    /**
     * Sets the strategy's name.
     *
     * @param string $name Strategy's name.
     */
    public function setName($name = null)
    {
        if (empty($name)) {
            $classname = explode('\\', get_class($this));
            $name = substr(array_pop($classname), 0, -strlen('Strategy'));
        }

        $this->name = $name;
    }
}
