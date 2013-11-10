<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 9/21/13
 */

namespace Acl\Controller;

use Acl\Entity\UserGroup;
use Acl\Marshal\UserGroupsWithResourceNamesToArray;
use Acl\Resource\Factory as ResourceFactory;
use Acl\Service\UserResource as UserResourceService;
use Acl\Service\UserGroup as UserGroupService;
use Auth\Controller\AuthenticatedController;
use InvalidArgumentException;
use User\Entity\User as UserEntity;
use User\Service as UserService;
use Zend\View\Model\ViewModel;

class UserResourceController extends AuthenticatedController
{
    /**
     * @var ResourceFactory
     */
    private $resourceFactory;

    /**
     * @var UserResourceService
     */
    private $userResourceService;

    /**
     * @var UserService
     */
    private $userService;

    /**
     * @var UserGroupService
     */
    private $userGroupService;

    /**
     * @var UserGroupsWithResourceNamesToArray
     */
    private $groupsToArrayMarshaller;

    /**
     * @param ResourceFactory $resourceFactory
     * @param UserResourceService $userResourceService
     * @param UserService $userService
     * @param UserGroupService $userGroupService
     */
    public function __construct(
        ResourceFactory $resourceFactory,
        UserResourceService $userResourceService,
        UserService $userService,
        UserGroupService $userGroupService,
        UserGroupsWithResourceNamesToArray $groupsToArray
    )
    {
        $this->resourceFactory = $resourceFactory;
        $this->userResourceService = $userResourceService;
        $this->userService = $userService;
        $this->userGroupService = $userGroupService;
        $this->groupsToArrayMarshaller = $groupsToArray;
    }

    /**
     * @return array|ViewModel
     */
    public function indexAction()
    {

    }

    /**
     * @return ViewModel
     * @throws \InvalidArgumentException
     */
    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if(empty($id)){
            throw new InvalidArgumentException('A valid user id must be provided');
        }
        /** @var UserEntity $user */
        $user = $this->userService->load($id);
        if(empty($user)){
            throw new InvalidArgumentException('A user with id ['.$id.'] was not found');
        }

        $resources = $this->resourceFactory->getTopResources();
        $selectedResources = $this->userResourceService->getResourceIdsByUserId($id);
        $userGroups = $this->userGroupService->getGroupsWithResourcesByUserId($id);
        $marshaledGroups = $this->groupsToArrayMarshaller->marshal($userGroups);
        return new ViewModel(array(
            'userId' => $id,
            'resources' => $resources,
            'selectedResources' => $selectedResources,
            'groups' => $marshaledGroups,
            'name' => $user->getName(),
            'email' => $user->getEmail()
        ));
    }
}