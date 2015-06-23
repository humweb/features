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
    public function handle($args = [])
    {
        $time = time();

        switch ($this->comparator) {
            case '<':
                $result = $time < $this->datetime;
                break;
            case '<=':
                $result = $time <= $this->datetime;
                break;
            case '>=':
                $result = $time >= $this->datetime;
                break;
            case '>':
                $result = $time > $this->datetime;
                break;
            case '==':
                $result = $time == $this->datetime;
                break;
            default:
                throw new \InvalidArgumentException('Bad comparison operator.');
        }

        return $result;
    }
}
