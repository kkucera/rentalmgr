<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 10/19/13
 */

namespace Acl\Resource;

use Acl\Entity\Permission;

class Acl extends AbstractResource
{

    /**
     * Return the integer id for this resource.  This should be a unique number across all resources you will
     * use in the application.
     * @return int
     */
    public function getId()
    {
        return 1;
    }

    /**
     * Return the name of this resource
     * @return string
     */
    public function getName()
    {
        return 'ACL';
    }

    /**
     * Return the description of this resource
     * @return string
     */
    public function getDescription()
    {
        return 'Grants the ability to see ACL management options.';
    }

    /**
     * @return Permission[]
     */
    public function definePermissions()
    {
        // this is just a parent resource which has no permissions;
    }

}