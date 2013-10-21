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

    /**
     * Return the integer id for this resource.  This should be a unique number across all resources you will
     * use in the application.
     * @return int
     */
    public function getId()
    {
        return 20;
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
        $this->addPermission(new User\View);
        $this->addPermission(new User\Create);
        $this->addPermission(new User\Edit);
        $this->addPermission(new User\Delete);
    }
}