<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 10/26/13
 */

namespace Core\Initializer\Helper;

use ReflectionClass;

class Injection {

    /**
     * Checks if the provided class instance is one of the given string class names provided in the white list array
     * @param string[] $whiteList
     * @return bool
     */
    public function isInstanceOf($instance, $whiteList)
    {
        foreach($whiteList as $className){
            if($instance instanceOf $className){
                return true;
            }
        }
        return false;
    }

    /**
     * Checks if the provided class name is a sub class of any class in the white list.
     * @param string $className
     * @param string[] $whiteList
     * @return bool
     */
    public function isSubclassOf($className, $whiteList)
    {
        $reflectionInterface = new ReflectionClass( $className );
        foreach ($whiteList as $requiredClassName) {
            if ($reflectionInterface->isSubclassOf($requiredClassName)) {
                return true;
            }
        }
        return false;
    }

}