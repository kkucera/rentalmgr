<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 9/18/13
 */
namespace Acl\Resource;

class Group extends AbstractResource
{

    /**
     * Return the name of this resource
     * @return string
     */
    public function getName()
    {
        return 'ACL Groups';
    }

    /**
     * Return the description of this resource
     * @return string
     */
    public function getDescription()
    {
        return 'Access to view, create, edit available groups';
    }

}