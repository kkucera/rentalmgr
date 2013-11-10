<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 10/19/13
 */

namespace Acl\Resource\Group;

use Acl\Resource\AbstractResource;
use Acl\Resource\Group;

class Create extends AbstractResource
{

    /**
     * Return the name of this resource
     * @return string
     */
    public function getName()
    {
        return 'Create';
    }

    /**
     * Return the description of this resource
     * @return string
     */
    public function getDescription()
    {
        return 'Create new access control groups';
    }

}