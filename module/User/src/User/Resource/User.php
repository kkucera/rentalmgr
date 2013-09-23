<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 9/22/13
 */

namespace User\Resource;

use Acl\Entity\Permission;
use Acl\Resource\AbstractResource;

class User extends AbstractResource
{

    const RESOURCE_ID = 20;
    const VIEW = 20;
    const EDIT = 21;
    const CREATE = 22;
    const DELETE = 23;

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
        return 'User';
    }

    /**
     * Return the description of this resource
     * @return string
     */
    public function getDescription()
    {
        return 'Ability to manager application users';
    }

    /**
     * @return Permission[]
     */
    public function definePermissions()
    {
        $this->addPermission(self::VIEW,'view','View application users');
        $this->addPermission(self::EDIT,'edit','Edit application users');
        $this->addPermission(self::CREATE,'create','Create application users');
        $this->addPermission(self::DELETE,'delete','Delete application users');
    }
}