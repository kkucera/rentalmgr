<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 10/2/13
 */

namespace Application\Marshal\Strategy;

use Zend\Stdlib\Hydrator\Strategy\StrategyInterface;
use Application\Marshal\EntityToArray;
use DoctrineModule\Stdlib\Hydrator\Strategy\AbstractCollectionStrategy;

class DoctrineEntity extends AbstractCollectionStrategy
{

    /**
     * @param mixed $value
     * @return array|mixed
     */
    public function extract($value)
    {
        $marshaller = new EntityToArray($value);
        return $marshaller->marshal($value);
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