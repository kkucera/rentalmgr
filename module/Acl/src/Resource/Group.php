<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 9/18/13
 */
namespace Acl\Resource;

use Acl\Entity\Permission;
use Acl\Resource\Acl;

class Group extends AbstractResource
{

    /**
     * Return the integer id for this resource.  This should be a unique number across all resources you will
     * use in the application.
     * @return int
     */
    public function getId()
    {
        return 10;
    }

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

    /**
     * @return Permission[]
     */
    public function definePermissions()
    {
        $this
            ->addPermission(new Group\View)
            ->addPermission(new Group\Edit)
            ->addPermission(new Group\Create)
            ->addPermission(new Group\Delete);
    }

    /**
     * @return Acl
     */
    public function getParent()
    {
        return new Acl();
    }
}