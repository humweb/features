<?php

namespace Humweb\Features\Strategy;

/**
 * Abstract strategy.
 */
abstract class AbstractStrategy implements StrategyInterface
{

    /**
     * Strategy name
     *
     * @var string
     */
    protected $name;


    /**
     * {@inheritdoc}
     */
    abstract public function handle($args);


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
     * {@inheritdoc}
     */
    public function setName($name = null)
    {
        if (empty($name)) {
            $classname = explode('\\', get_class($this));
            $name = substr(array_pop($classname), 0, -strlen('Strategy'));
        }

        $this->name = $name;
        return $this;

    }

    protected function argGet($ary = [], $key, $default = null)
    {
        return isset($ary[$key]) ? $ary[$key] : $default;
    }
}
