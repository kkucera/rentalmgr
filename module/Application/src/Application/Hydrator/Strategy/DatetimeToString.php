<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 10/2/13
 */

namespace Application\Hydrator\Strategy;

use Zend\Stdlib\Hydrator\Strategy\StrategyInterface;
use DateTime;

class DatetimeToString implements StrategyInterface
{

    /**
     * Formats a datetime into a string
     *
     * @param DateTime $value The original value.
     * @return string
     */
    public function extract($value)
    {
        if(!$value instanceof DateTime){
            return null;
        }
        return $value->format('Y-m-d H:i:s');
    }

    /**
     * @param mixed $value
     * @return mixed
     */
    public function hydrate($value)
    {
        return $value;
    }
}