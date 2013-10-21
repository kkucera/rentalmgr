<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 10/6/13
 */

namespace Auth\Controller\Service;

use Application\Controller\AbstractController;
use Zend\View\Model\JsonModel;

class AuthorizationController extends AbstractController
{

    /**
     * @return \Auth\Service\Authentication
     */
    protected function getAuthService()
    {
        return $this->getServiceLocator()->get('Auth\Service\Authentication');
    }

    /**
     * Touch the current session and update it's last accessed time
     */
    public function touchAction()
    {
        $authService = $this->getAuthService();
        $authService->touchLastAccessed();
        return new JsonModel(array('success'=>true));
    }

}