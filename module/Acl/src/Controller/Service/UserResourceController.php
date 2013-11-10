<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 10/2/13
 */

namespace Acl\Controller\Service;

use Acl\Entity\UserResource;
use Acl\Service\Resource as ResourceService;
use Acl\Service\UserResource as UserResourceService;
use Application\Controller\AbstractCrudServiceController;
use InvalidArgumentException;
use Zend\View\Model\JsonModel;

class UserResourceController extends AbstractCrudServiceController
{

    /**
     * @var ResourceService
     */
    private $resourceService;

    /**
     * @var UserResourceService
     */
    private $userResourceService;

    /**
     * @return UserResource
     */
    protected function getEntity()
    {
        return new UserResource();
    }

    /**
     * @return UserResourceService
     */
    protected function getEntityService()
    {
        return $this->userResourceService;
    }

    /**
     * @param ResourceService $resourceService
     * @param UserResourceService $userResourceService
     */
    public function __construct(ResourceService $resourceService, UserResourceService $userResourceService)
    {
        $this->resourceService = $resourceService;
        $this->userResourceService = $userResourceService;
    }


    /**
     * Gets all groups for a given user
     */
    public function getUserResourcesAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if(empty($id)){
            throw new InvalidArgumentException('Missing required parameter [id].');
        }
        $entities = $this->getEntityService()->getUserResourcesByUserId($id);
        $hydrator = $this->getEntityHydrator();
        return new JsonModel($hydrator->extractAll($entities));
    }

    /**
     * Gets all group ids for a given user
     */
    public function getUserResourceIdsAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if(empty($id)){
            throw new InvalidArgumentException('Missing required parameter [id].');
        }
        $ids = $this->getEntityService()->getResourceIdsByUserId($id);
        return new JsonModel($ids);
    }

    /**
     * @return JsonModel
     */
    public function saveUserResourcesAction()
    {
        $data = $this->params()->fromPost();
        $userId = $data['userId'];
        $resources = $data['resource'] ?: array();
        $this->userResourceService->updateUserResources($userId, $resources);
        return new JsonModel(array('success'=>true));
    }

}