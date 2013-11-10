<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 10/26/13
 */

namespace Acl\Service\Interfaces;

use Acl\Service\Resource as ResourceService;
use Core\Initializer\Interfaces\InjectViaInitializerInterface;

interface ResourceAwareInterface extends InjectViaInitializerInterface
{

    /**
     * @param ResourceService $service
     * @return mixed
     */
    public function setResourceService(ResourceService $service);

}