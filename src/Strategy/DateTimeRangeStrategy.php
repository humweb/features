<?php

namespace Humweb\Features\Strategy;

/**
 * DateTimeRange strategy.
 */
class DateTimeRangeStrategy extends AbstractStrategy
{

    /**
     * {@inheritdoc}
     */
    public function handle($args = [])
    {

        $strict = $this->argGet($args, 'strict', true);

        $dateRange = [
            [
                'date'     => $this->argGet($args, 'start'),
                'operator' => '<'
            ],
            [
                'date'     => $this->argGet($args, 'end'),
                'operator' => '>'
            ]
        ];

        foreach ($dateRange as $range) {

            if ( ! $strict) {
                $range['operator'] .= '=';
            }

            if ($this->runDateTimeStrategy($range['date'], $range['operator']) === false) {
                return false;
            }
        }

        return true;
    }


    /**
     * Run datetime strategy
     *
     * @param string|\DateTime $datetime
     * @param string           $operator
     *
     * @return bool
     */
    public function runDateTimeStrategy($datetime, $operator = '>=')
    {
        $strategy = new DateTimeStrategy();

        $args = [
            'datetime' => $datetime,
            'operator' => $operator
        ];

        if ( ! call_user_func_array([$strategy, 'handle'], [$args])) {
            return false;
        }

        return true;
    }
}
