<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 9/28/13
 */

namespace Application\Marshal;

class EntitiesToArray extends EntityToArray
{
    /**
     * @param $collection
     * @return array
     */
    public function marshal($collection)
    {
        $entitiesArray = array();
        foreach($collection as $entity){
            $entitiesArray[] = parent::marshal($entity);
        }
        return $entitiesArray;
    }

}