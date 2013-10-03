<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 9/2/13
 */

namespace Acl\Controller\Service;

use Acl\Entity\Group;
use Application\Controller\AbstractCrudServiceController;

class GroupController extends AbstractCrudServiceController
{
    /**
     * @return Object
     */
    protected function getEntity()
    {
        return new Group;
    }

    /**
     * @return \Acl\Service\Group
     */
    protected function getEntityService()
    {
        return $this->getServiceLocator()->get('Acl\Service\Group');
    }
}