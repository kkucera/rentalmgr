<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 10/2/13
 */

namespace Acl\Controller\Service;

use Acl\Entity\UserPermission;
use Application\Controller\AbstractCrudServiceController;
use Application\CrudServiceAbstract;
use InvalidArgumentException;
use Zend\View\Model\JsonModel;

class UserPermissionController extends AbstractCrudServiceController
{

    /**
     * @return UserPermission
     */
    protected function getEntity()
    {
        return new UserPermission();
    }

    /**
     * @return \Acl\Service\UserPermission
     */
    protected function getEntityService()
    {
        return $this->getServiceLocator()->get('Acl\Service\UserPermission');
    }

    /**
     * Gets all groups for a given user
     */
    public function getUserPermissionsAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if(empty($id)){
            throw new InvalidArgumentException('Missing required parameter [id].');
        }
        $entities = $this->getEntityService()->getPermissionsByUserId($id);
        $hydrator = $this->getEntityHydrator();
        return new JsonModel($hydrator->extractAll($entities));
    }

    /**
     * Gets all group ids for a given user
     */
    public function getUserPermissionIdsAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if(empty($id)){
            throw new InvalidArgumentException('Missing required parameter [id].');
        }
        $ids = $this->getEntityService()->getPermissionIdsForUserId($id);
        return new JsonModel($ids);
    }

}