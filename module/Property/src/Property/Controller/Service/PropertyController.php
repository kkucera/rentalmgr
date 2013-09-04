<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 9/2/13
 */

namespace Property\Controller\Service;

use Application\Controller\AbstractServiceController;
use InvalidArgumentException;
use Property\Entity\Property;
use Property\Marshal\ArrayToProperty;
use Property\Marshal\PropertiesToArray;
use Property\Marshal\PropertyToArray;
use Property\Service;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\View\Model\JsonModel;

class PropertyController extends AbstractServiceController
{

    /**
     * @return Property
     */
    protected function getProperty()
    {
        return new Property();
    }

    /**
     * @return ArrayToProperty
     */
    protected function getArrayToPropertyMarshaller()
    {
        return new ArrayToProperty();
    }

    /**
     * @return PropertyToArray
     */
    protected function getPropertyToArrayMarshaller()
    {
        return new PropertyToArray();
    }

    /**
     * @return PropertiesToArray
     */
    protected function getPropertiesToArrayMarshaller()
    {
        return new PropertiesToArray();
    }

    /**
     * @return \Property\Service
     */
    protected function getPropertyService()
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