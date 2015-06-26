<?php

namespace Humweb\Features\Strategy;

use DateTime;

/**
 * DateTime strategy.
 */
class DateTimeStrategy extends AbstractStrategy
{

    /**
     * {@inheritdoc}
     */
    public function handle($args = [])
    {
        $operator = $this->argGet($args, 'operator', '>=');
        $datetime = $this->argGet($args, 'datetime', time());

        if ( ! ($datetime instanceof DateTime)) {
            $datetime = new DateTime($datetime);
        }

        return $this->compare($datetime, new DateTime(), $operator);
    }


    /**
     * Compare two datetime objects
     *
     * @param DateTime $a
     * @param DateTime $b
     * @param string   $operator
     *
     * @return bool
     */
    protected function compare($a, $b, $operator = '>=')
    {
        switch ($operator) {
            case '<':
                return $a < $b;
            case '<=':
                return $a <= $b;
            case '>=':
                return $a >= $b;
            case '>':
                return $a > $b;
            case '==':
            case '===':
                return $a == $b;
            case '!=':
            case '!==':
                return $a != $b;
            default:
                throw new \InvalidArgumentException('Invalid comparison operator.');
        }
    }
}
