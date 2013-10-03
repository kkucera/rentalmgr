<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 9/28/13
 */

namespace Application\Marshal;

class ArrayToEntity extends EntityAbstract
{
    /**
     * @param $data
     * @return Object
     */
    public function marshal($data)
    {
        $entity = $this->getEntity();

        $hydrator = $this->getEntityHydrator(
            $this->getEntityManager(),
            get_class($entity)
        );

        return $hydrator->hydrate($data, $entity);
    }
}