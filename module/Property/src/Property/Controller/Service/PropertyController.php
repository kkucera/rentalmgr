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
use Property\Entity\Property;
use Property\Marshal\ArrayToProperty;
use Property\Service;

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
     * @return \Property\Service
     */
    protected function getPropertyService()
    {
        return new Service();
    }

    public function indexAction()
    {
        echo 'nothing here';
    }

    public function createAction()
    {
        $data = $_POST;

        $marshaller = $this->getArrayToPropertyMarshaller();
        $property = $marshaller->marshal($data);

        $service = $this->getPropertyService();
        $property = $service->create($property);

        die(var_dump($property->getId())); // yes, I'm lazy
    }

    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if(empty($id)){
            // throw an exception
            die();
        }

        $service = $this->getPropertyService();
        $property = $service->delete($id);

        die( 'OK - deleted: '.$id ); // yes, I'm lazy
    }

    public function getAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if(empty($id)){
            // throw an exception
            die();
        }

        $service = $this->getPropertyService();
        $property = $service->load($id);

        var_dump($property);
        die();
    }

    public function getlistAction()
    {
        $service = $this->getPropertyService();
        $properties = $service->getList();
        var_dump($properties);
        die();
    }
}