<?php

namespace Humweb\Features;

use Humweb\Features\Resolvers\StrategyResolver;
use Humweb\Features\Strategy\StrategyInterface;

/**
 * StrategyCollection.
 */
class StrategyCollection implements \ArrayAccess
{
    const STATUS_DISABLED = 0;
    const STATUS_ENABLED = 1;

    /**
     * @var array
     */
    public $strategies;

    protected $resolver;

    protected $status = 1;

    protected $threshold = 1;

    /**
     * @param array $strategies
     */
    public function __construct($strategies = array())
    {
        $this->resolver = new StrategyResolver();
        $this->strategies = $strategies;
    }

    /**
     * Adds strategies to feature object.
     *
     * @param string                     $name
     * @param callable|StrategyInterface $strategy
     *
     * @return $this
     */
    public function add($name, $strategy = null, $args = [])
    {
        if (is_array($name)) {
            $strategy = $name;
            foreach ($strategy as $name => $class) {
                $args = isset($class[1]) ? $class[1] : [];
                $this->addStrategy($name, $class[0], $args);
            }
        } else {
            $this->addStrategy($name, $strategy, $args);
        }

        return $this;
    }

    /**
     * Adds strategy to feature object.
     *
     * @param string $name
     * @param string $class Strategy class name.
     * @param array  $args
     *
     * @return $this
     * @throws InvalidArgumentException
     */
    public function addStrategy($name, $class, $args = [])
    {
        if (is_callable($class)) {
            $this->strategies['__'.$name] = [
                'class' => $class,
                'args' => $args,
            ];
        } elseif ($class instanceof StrategyInterface) {
            $this->strategies[$name] = [
                'class' => '\\'.trim($class, '\\'),
                'args' => $args,
            ];
        } else {

            // Strategy must be a string
            if (!is_string($class)) {
                throw new InvalidArgumentException(sprintf('Expected a string. Actual: %s', gettype($class)));
            }

            $class = $this->resolver->resolve($class);

            $this->strategies[$name] = [
                'class' => $class,
                'args' => $args,
            ];
        }

        return $this;
    }

    public function count()
    {
        return count($this->strategies);
    }

    public function flush()
    {
        return $this->strategies = [];
    }

    public function check($args = [])
    {
        if ($this->status === self::STATUS_DISABLED) {
            return false;
        }

        $isEnabled = 0;
        foreach ($this->strategies as $name => $strategy) {
            if ($this->isClosureStrategy($name)) {
                if ($strategy['class']($strategy['args'])) {
                    $isEnabled++;
                }
            } else {
                $obj = new $strategy['class']();
                if ($obj->handle($strategy['args'])) {
                    $isEnabled++;
                }
            }
        }

        return $isEnabled >= $this->threshold;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Whether a offset exists.
     *
     * @link http://php.net/manual/en/arrayaccess.offsetexists.php
     *
     * @param mixed $offset <p>
     *                      An offset to check for.
     *                      </p>
     *
     * @return bool true on success or false on failure.
     *              </p>
     *              <p>
     *              The return value will be casted to boolean if non-boolean was returned.
     */
    public function offsetExists($offset)
    {
        return isset($this->strategies[$offset]) || isset($this->strategies['__'.$offset]);
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Offset to retrieve.
     *
     * @link http://php.net/manual/en/arrayaccess.offsetget.php
     *
     * @param mixed $offset <p>
     *                      The offset to retrieve.
     *                      </p>
     *
     * @return mixed Can return all value types.
     */
    public function offsetGet($offset)
    {
        if (isset($this->strategies[$offset])) {
            return $this->strategies[$offset];
        }

        return $this->strategies['__'.$offset];
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Offset to set.
     *
     * @link http://php.net/manual/en/arrayaccess.offsetset.php
     *
     * @param mixed $offset <p>
     *                      The offset to assign the value to.
     *                      </p>
     * @param mixed $value  <p>
     *                      The value to set.
     *                      </p>
     */
    public function offsetSet($offset, $value)
    {
        $this->strategies[$offset] = $value;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Offset to unset.
     *
     * @link http://php.net/manual/en/arrayaccess.offsetunset.php
     *
     * @param mixed $offset <p>
     *                      The offset to unset.
     *                      </p>
     */
    public function offsetUnset($offset)
    {
        unset($this->strategies[$offset]);
    }

    public function off()
    {
        $this->status = self::STATUS_DISABLED;

        return $this;
    }

    public function on()
    {
        $this->status = self::STATUS_ENABLED;

        return $this;
    }

    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param int $threshold
     *
     * @return StrategyCollection
     */
    public function setThreshold($threshold)
    {
        $this->threshold = $threshold;

        return $this;
    }

    protected function isClosureStrategy($key = '')
    {
        return substr($key, 0, 2) === '__';
    }

    /**
     * @return int
     */
    public function getThreshold()
    {
        return $this->threshold;
    }

    /**
     * @return array
     */
    public function getStrategies()
    {
        return $this->strategies;
    }
}
