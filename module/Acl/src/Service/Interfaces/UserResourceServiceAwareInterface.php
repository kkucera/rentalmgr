<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 10/27/13
 */

namespace Acl\Service\Interfaces;

use Acl\Service\UserResource as UserResourceService;
use Core\Initializer\Interfaces\InjectViaInitializerInterface;

interface UserResourceServiceAwareInterface extends InjectViaInitializerInterface
{
    /**
     * @param UserResourceService $service
     * @return mixed
     */
    public function setUserResourceService(UserResourceService $service);

}