<?php

namespace Humweb\Features;

use Humweb\Features\Strategy\StrategyInterface;

/**
 * Feature registry.
 */
class Features
{
    /**
     * Features collections.
     *
     * @var array
     */
    protected $features = [];


    /**
     * Create new feature.
     *
     * @param string $name        Feature identifier.
     * @param string $description Feature description
     * @param array  $strategies  array of strategies
     *
     * @return StrategyCollection
     */
    public function create($name, $description = '', $strategies = [])
    {
        if ($this->exists($name)) {
            throw new \InvalidArgumentException('Duplicate feature identifier.');
        }

        $this->features[$name] = [
            'description' => $description,
            'collection'  => new StrategyCollection($strategies),
        ];

        return $this->features[$name]['collection'];
    }


    /**
     * @param string                            $feature      Feature identifier
     * @param string                            $strategyName Strategy name
     * @param string|callable|StrategyInterface $strategy     Strategy class or closure
     * @param array                             $args
     */
    public function pushStrategy($feature, $strategyName, $strategy = null, $args = [])
    {
        if ( ! $this->exists($feature)) {
            throw new \InvalidArgumentException('Duplicate feature identifier.');
        }
        $this->getCollection($feature)->add($strategyName, $strategy, $args);
    }


    /**
     * Get Collection by feature name
     *
     * @param string $name Feature identifier
     *
     * @return StrategyCollection
     */
    public function getCollection($name)
    {
        return $this->get($name, 'collection');
    }


    /**
     * Checks if a feature with given name exists.
     *
     * @param string $name Feature identifier.
     *
     * @return bool
     */
    public function exists($name)
    {
        return isset($this->features[$name]);
    }


    /**
     * Flush all features.
     */
    public function flush()
    {
        $this->features = [];
    }


    /**
     * Returns feature or array item from feature array.
     *
     * @param string      $name
     * @param null|string $key
     *
     * @return
     */
    public function get($name, $key = null)
    {
        if ( ! $this->exists($name)) {
            throw new \InvalidArgumentException('Unknown feature identifier.');
        }

        return ! is_null($key) ? $this->features[$name][$key] : $this->features[$name];
    }


    /**
     * @param string $feature Feature identifier
     * @param array  $args    arguments passed to strategies checker
     *
     * @return bool
     */
    public function isEnabled($feature, array $args = [])
    {
        return $this->getCollection($feature)->check($args);
    }


    /**
     * @param string $name Feature identifier
     * @param int    $threshold
     *
     * @return $this
     */
    public function setThreshold($name, $threshold = 1)
    {
        $this->getCollection($name)->setThreshold($threshold);

        return $this;
    }
}
