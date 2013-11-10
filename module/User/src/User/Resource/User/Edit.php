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

class Edit extends AbstractResource
{

    /**
     * Return the name of this resource
     * @return string
     */
    public function getName()
    {
        return 'Edit';
    }

    /**
     * Return the description of this resource
     * @return string
     */
    public function getDescription()
    {
        return 'Edit existing users';
    }
}