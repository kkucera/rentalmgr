<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 9/21/13
 */

namespace Acl\Controller;

use Auth\Controller\AuthenticatedController;
use Acl\Resource\Group as GroupResource;

class GroupController extends AuthenticatedController
{

    public function indexAction()
    {
        $this->userHasPermission(GroupResource::VIEW);
    }

}