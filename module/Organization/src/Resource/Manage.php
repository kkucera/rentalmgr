<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 11/24/13
 */

namespace Organization\Resource;

use Acl\Resource\AbstractResource;

class Manage extends AbstractResource
{

    /**
     * Return the name of this resource
     * @return string
     */
    public function getName()
    {
        return 'Manage Organizations';
    }

    /**
     * Return the description of this resource
     * @return string
     */
    public function getDescription()
    {
        return 'Ability to manage organizations';
    }

    /**
     * Override the type to be a system level acl
     * @return int
     */
    public function getType()
    {
        return self::TYPE_SYSTEM;
    }
}