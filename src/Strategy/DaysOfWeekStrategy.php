<?php

namespace Humweb\Features\Strategy;

use DateTime;

class DaysOfWeekStrategy extends AbstractStrategy
{

    protected $days = [
        1 => ['mon', 'monday'],
        2 => ['tue', 'tuesday'],
        3 => ['wed', 'wednesday'],
        4 => ['thu', 'thursday'],
        5 => ['fri', 'friday'],
        6 => ['sat', 'saturday'],
        7 => ['sun', 'sunday']
    ];


    /**
     * {@inheritdoc}
     */
    public function handle($args = [])
    {

        $days = (array)$this->argGet($args, 'days', []);

        $dayNames = $this->getDayNames();

        foreach ($days as $day) {
            if ($this->daysMatch($dayNames, $day)) {
                return true;
            }
        }

        return false;
    }


    /**
     * Get day name
     *
     * @return array
     */
    protected function getDayNames()
    {
        return $this->days[(new DateTime())->format('N')];
    }


    /**
     * @param array  $todayNames
     * @param string $matchDay
     *
     * @return bool
     */
    protected function daysMatch($todayNames, $matchDay)
    {
        return in_array(strtolower($matchDay), $todayNames);
    }
}
