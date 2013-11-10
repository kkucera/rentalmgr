<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 10/27/13
 */

namespace Acl\Initializer\Interfaces;

use Acl\Service\ZendAcl;
use Auth\Initializer\Interfaces\RequireAuthenticationInterface;

interface RequiresZendAclInterface extends RequireAuthenticationInterface
{

    /**
     * @param ZendAcl $acl
     * @return mixed
     */
    public function setZendAcl(ZendAcl $acl);

    /**
     * @return ZendAcl
     */
    public function getZendAcl();

}