<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 9/2/13
 */

namespace Acl\Controller\Service;

use Application\Controller\AbstractServiceController;
use InvalidArgumentException;
use User\Entity\User;
use User\Marshal\ArrayToUser;
use User\Marshal\UsersToArray;
use User\Marshal\UserToArray;
use User\Service;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\View\Model\JsonModel;

class GroupController extends AbstractServiceController
{

    /**
     * @return User
     */
    protected function getUser()
    {
        return new User();
    }

    /**
     * @return ArrayToUser
     */
    protected function getArrayToUserMarshaller()
    {
        return new ArrayToUser();
    }

    /**
     * @return UserToArray
     */
    protected function getUserToArrayMarshaller()
    {
        return new UserToArray();
    }

    /**
     * @return UsersToArray
     */
    protected function getUsersToArrayMarshaller()
    {
        return new UsersToArray();
    }

    /**
     * @return \User\Service
     */
    protected function getUserService()
    {
        return new Service();
    }

    public function indexAction()
    {
        throw new ServiceNotFoundException('There is no default property service.');
    }

    public function createAction()
    {
        $data = $_POST;

        $marshaller = $this->getArrayToPropertyMarshaller();
        $property = $marshaller->marshal($data);

        $service = $this->getPropertyService();
        $property = $service->create($property);

        $marshaller = $this->getPropertyToArrayMarshaller();

        return new JsonModel($marshaller->marshal($property));
    }

    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if(empty($id)){
            throw new InvalidArgumentException('Missing required parameter [id].');
        }

        $service = $this->getPropertyService();
        $property = $service->delete($id);

        return new JsonModel(array(
            'id' => $id,
            'success' => true,
        ));
    }

    public function getAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if(empty($id)){
            throw new InvalidArgumentException('Missing required parameter [id].');
        }

        $service = $this->getPropertyService();
        $property = $service->load($id);

        $marshaller = $this->getPropertyToArrayMarshaller();

        return new JsonModel($marshaller->marshal($property));
    }

    public function getlistAction()
    {
        $service = $this->getPropertyService();
        $properties = $service->getList();
        $marshaller = $this->getPropertiesToArrayMarshaller();
        return new JsonModel($marshaller->marshal($properties));
    }
}