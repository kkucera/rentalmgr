<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 9/2/13
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Application\ServiceLocator;
use Zend\Mvc\MvcEvent;

class AbstractController extends AbstractActionController{

    /**
     * Execute the request
     *
     * @param  MvcEvent $e
     * @return mixed
     * @throws \Zend\Mvc\Exception\DomainException
     */
    public function onDispatch(MvcEvent $e)
    {
        ServiceLocator::register($this->getServiceLocator());
        return parent::onDispatch($e);
    }

}