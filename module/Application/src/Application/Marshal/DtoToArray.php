<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 9/3/13
 */

namespace Application\Marshal;

use ReflectionClass;
use ReflectionMethod;

class DtoToArray extends MarshallerAbstract
{
    /**
     * Converts public method getters into array properties
     * @param $dto
     * @return array
     */
    public function marshal($dto)
    {
        $result = array();
        $reflection = new ReflectionClass($dto);
        $publicMethods = $reflection->getMethods(ReflectionMethod::IS_PUBLIC);
        foreach($publicMethods as $method){
            $methodName = $method->getName();
            if(strpos($methodName,'get') === 0){
                $propertyName = substr($methodName,3);
                $result[$propertyName] = $dto->$methodName();
            }
        }
        return $result;
    }
}