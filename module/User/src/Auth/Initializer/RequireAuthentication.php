<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 10/27/13
 */

namespace Auth\Initializer;

use Auth\Exception\UserNotAuthenticated;
use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\InitializerInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Auth\Initializer\Interfaces\RequireAuthenticationInterface;

class RequireAuthentication implements InitializerInterface
{

    /**
     * @param $instance
     * @param ServiceLocatorInterface $serviceLocator
     * @return RequireAuthenticationInterface|mixed
     * @throws UserNotAuthenticated
     */
    public function initialize($instance, ServiceLocatorInterface $serviceLocator)
    {

        // this initializer only works on instances the implement the RequireAuthenticationInterface
        if(!$instance instanceof RequireAuthenticationInterface){
            return $instance;
        }

        // set the current user if not already set
        $user = $instance->getUser();
        if(empty($user)){
            if ($serviceLocator instanceof AbstractPluginManager)
            {
                $serviceLocator = $serviceLocator->getServiceLocator();
            }
            /** @var \Auth\Service\Authentication $authService */
            $authService = $serviceLocator->get('Auth\Service\Authentication');
            $user = $authService->getUser();
            if(empty($user)){
                throw new UserNotAuthenticated('User must be authenticated to access the requested service');
            }
            $instance->setUser($user);
        }

        return $instance;
    }
}