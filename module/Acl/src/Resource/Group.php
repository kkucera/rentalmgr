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

class Group extends AbstractResource
{

    const RESOURCE_ID = 10;
    const VIEW = 10;
    const EDIT = 11;
    const CREATE = 12;
    const DELETE = 13;

    /**
     * Return the integer id for this resource.  This should be a unique number across all resources you will
     * use in the application.
     * @return int
     */
    public function getId()
    {
        return self::RESOURCE_ID;
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
            ->addPermission(
                self::VIEW,
                'view',
                'View available access control groups.'
            )
            ->addPermission(
                self::EDIT,
                'edit',
                'Edit available access control groups.'
            )
            ->addPermission(
                self::CREATE,
                'create',
                'Create new access control groups.'
            )
            ->addPermission(
                self::DELETE,
                'delete',
                'Delete available access control groups.'
            );
    }
}