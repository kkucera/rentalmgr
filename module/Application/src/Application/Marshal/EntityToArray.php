<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 9/28/13
 */

namespace Application\Marshal;

class EntityToArray extends EntityAbstract
{
    /**
     * @param $entity Object
     * @return array
     */
    public function marshal($entity)
    {

        $hydrator = $this->getEntityHydrator(
            $this->getEntityManager(),
            get_class($entity)
        );

        return $hydrator->extract($entity);
    }
}