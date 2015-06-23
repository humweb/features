<?php

namespace Humweb\Features\Strategy;

/**
 * DateTimeRange strategy.
 */
class DateTimeRangeStrategy extends AbstractStrategy
{
    /**
     * Include start and end date time or not.
     *
     * @var bool
     */
    protected $inclusive;

    /**
     * Maximum date time.
     *
     * @var string
     */
    protected $maxRange;

    /**
     * Minimum date time.
     *
     * @var string
     */
    protected $minRange;

    /**
     * Constructor.
     *
     * @param string $minRange  Minimum date time.
     * @param string $maxRange  Maximum date time.
     * @param bool   $inclusive Include minimum and maximum dates in range.
     */
    public function __construct($minRange, $maxRange, $inclusive = false)
    {
        $this->inclusive = $inclusive;
        $this->maxRange = $maxRange;
        $this->minRange = $minRange;
    }


    /**
     * @param       $feature
     * @param array $args
     *
     * @return bool
     */
    public function handle($feature, array $args = [])
    {
        $strategies = array();
        $comparators = array('minRange' => '>', 'maxRange' => '<');

        foreach ($comparators as $var => $comparator) {
            if ($this->inclusive) {
                $comparator .= '=';
            }
            $strategies[$var] = $this->asDateTimeStrategy($this->$var, $comparator);
        }

        $result = true;
        foreach ($strategies as $var => $Strategy) {
            if (!call_user_func($Strategy, $feature)) {
                $result = false;
            }
        }

        return $result;
    }

    public function asDateTimeStrategy($datetime, $comparator)
    {
        return new DateTimeStrategy($datetime, $comparator);
    }
}
