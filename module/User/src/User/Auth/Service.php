<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 9/7/13
 */

namespace User\Auth;

use Application\ServiceLocator;
use User\Auth\Exception\LoginFailed;
use User\Entity\User;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class Service implements ServiceLocatorAwareInterface
{

    /**
     * @var ServiceLocatorInterface
     */
    private $serviceLocator;

    /**
     * @return \Zend\Authentication\AuthenticationService
     */
    protected function getAuthenticationService()
    {
        return $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
    }

    /**
     * @return ServiceLocatorInterface
     */
    public function getServiceLocator()
    {
        if(empty($this->serviceLocator)){
            $this->serviceLocator = new ServiceLocator();
        }
        return $this->serviceLocator;
    }

    /**
     * @return User|null
     */
    public function getUser()
    {
        $authService = $this->getAuthenticationService();
        return $authService->getIdentity();
    }

    /**
     *
     */
    public function logout()
    {
        $authService = $this->getAuthenticationService();
        $authService->clearIdentity();
    }

    /**
     * @param ServiceLocatorInterface $serviceLocator
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

    /**
     * @param $username
     * @param $password
     * @return bool
     * @throws Exception\LoginFailed
     */
    public function validate($username, $password)
    {
        $authService = $this->getAuthenticationService();

        /** @var \DoctrineModule\Authentication\Adapter\ObjectRepository $adapter */
        $adapter = $authService->getAdapter();
        $adapter->setIdentityValue($username);
        $adapter->setCredentialValue($password);
        $authResult = $authService->authenticate();

        if(!$authResult->isValid()){
            throw new LoginFailed($authResult->getMessages());
        }
        return true;
    }




}