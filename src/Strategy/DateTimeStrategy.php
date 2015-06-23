<?php

namespace Humweb\Features\Strategy;

/**
 * DateTime strategy.
 */
class DateTimeStrategy extends AbstractStrategy
{
    /**
     * Date time to use in comparison.
     *
     * @var string
     */
    protected $datetime;

    /**
     * Comparison operator.
     *
     * @var string
     */
    protected $comparator;


    /**
     * Constructor.
     *
     * @param string $datetime   Date time to use in comparison.
     * @param string $comparator Comparison operator.
     */
    public function __construct($datetime, $comparator = '>=')
    {
        $this->datetime = $datetime;
        $this->comparator = $comparator;
    }


    /**
     * {@inheritdoc}
     */
    public function handle($Feature, array $args = [])
    {
        $time = $this->getCurrentTime();
        $datetime = strtotime($this->datetime);

        switch ($this->comparator) {
            case '<':
                $result = $time < $datetime;
                break;
            case '<=':
                $result = $time <= $datetime;
                break;
            case '>=':
                $result = $time >= $datetime;
                break;
            case '>':
                $result = $time > $datetime;
                break;
            case '==':
                $result = $time == $datetime;
                break;
            default:
                throw new \InvalidArgumentException('Bad comparison operator.');
        }

        return $result;
    }


    /**
     * Returns the current time. Used for dependency injection.
     *
     * @return string
     */
    public function getCurrentTime()
    {
        return time();
    }
}
