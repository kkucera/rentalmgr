<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 10/19/13
 */

namespace User\Resource\User;

use Acl\Resource\AbstractResource;

class View extends AbstractResource
{

    /**
     * Return the name of this resource
     * @return string
     */
    public function getName()
    {
        return 'View';
    }

    /**
     * Return the description of this resource
     * @return string
     */
    public function getDescription()
    {
        return 'View existing users';
    }
}