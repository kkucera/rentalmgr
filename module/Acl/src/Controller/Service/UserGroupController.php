<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 9/28/13
 */

namespace Acl\Controller\Service;

use Acl\Entity\UserGroup;
use Application\Controller\AbstractCrudServiceController;
use InvalidArgumentException;
use Zend\View\Model\JsonModel;

class UserGroupController extends AbstractCrudServiceController
{
    /**
     * @return Object
     */
    protected function getEntity()
    {
        return new UserGroup;
    }

    /**
     * @return \Acl\Service\UserGroup
     */
    protected function getEntityService()
    {
        return $this->getServiceLocator()->get('Acl\Service\UserGroup');
    }

    /**
     * Gets all groups for a given user
     */
    public function getUserGroupsAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if(empty($id)){
            throw new InvalidArgumentException('Missing required parameter [id].');
        }
        $entities = $this->getEntityService()->getGroupsByUserId($id);
        $marshaller = $this->getEntitiesToArrayMarshaller();
        return new JsonModel($marshaller->marshal($entities));
    }

    /**
     * Gets all group ids for a given user
     */
    public function getUserGroupIdsAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if(empty($id)){
            throw new InvalidArgumentException('Missing required parameter [id].');
        }
        $entities = $this->getEntityService()->getGroupsByUserId($id);
        $ids = array();
        foreach($entities as $entity){
            $ids[] = $entity->getId();
        }
        return new JsonModel($ids);
    }

}