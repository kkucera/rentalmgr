<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 8/31/13
 */

namespace Property\Controller;

use Application\Controller\AbstractController;
use Property\Entity\Property;
use Property\Marshal\ArrayToProperty;
use Property\Service;

class PropertyController extends AbstractController
{

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

    }

    public function addAction()
    {

    }

    public function editAction()
    {

    }

    public function deleteAction()
    {

    }

}