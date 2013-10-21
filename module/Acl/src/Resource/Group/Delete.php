<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 10/19/13
 */

namespace Acl\Resource\Group;

use Acl\Resource\AbstractPermission;
use Acl\Resource\Group;

class Delete extends AbstractPermission
{

    /**
     * Return the integer id for this resource.  This should be a unique number across all resources you will
     * use in the application.
     * @return int
     */
    public function getId()
    {
        return 13;
    }

    /**
     * Return the name of this resource
     * @return string
     */
    public function getName()
    {
        return 'Delete';
    }

    /**
     * Return the description of this resource
     * @return string
     */
    public function getDescription()
    {
        return 'Delete available access control groups';
    }

    /**
     * @return Group
     */
    public function getParentResource()
    {
        return new Group;
    }
}