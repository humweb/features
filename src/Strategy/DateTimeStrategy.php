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


    protected function compare($a, $b, $operator = '>=')
    {
        switch ($operator) {
            case '<':
                return $a < $b;
                break;
            case '<=':
                return $a <= $b;
                break;
            case '>=':
                return $a >= $b;
                break;
            case '>':
                return $a > $b;
                break;
            case '==':
            case '===':
                return $a == $b;
                break;
            case '!=':
            case '!==':
                return $a != $b;
                break;
            default:
                throw new \InvalidArgumentException('Invalid comparison operator.');
        }
    }
}
