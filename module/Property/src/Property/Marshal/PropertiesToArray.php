<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 9/2/13
 */

namespace Property\Marshal;

use Application\Marshal\MarshallerAbstract;
use Property\Marshal\PropertyToArray;

class PropertiesToArray extends MarshallerAbstract
{
    /**
     * @return PropertyToArray
     */
    public function getPropertyToArrayMarshaller()
    {
        return new PropertyToArray();
    }

    /**
     * @param $collection
     * @return array
     */
    public function marshal($collection)
    {
        $properties = array();
        $marshaller = $this->getPropertyToArrayMarshaller();
        foreach($collection as $property){
            $properties[] = $marshaller->marshal($property);
        }
        return $properties;
    }

}