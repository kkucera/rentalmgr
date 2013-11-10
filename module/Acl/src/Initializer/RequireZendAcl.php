<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 10/27/13
 */

namespace Acl\Initializer;

use Acl\Initializer\Interfaces\RequiresZendAclInterface;
use Acl\Service\ZendAcl;
use Auth\Initializer\RequireAuthentication;
use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\ServiceLocatorInterface;

class RequireZendAcl extends RequireAuthentication
{
    /**
     * Initialize
     *
     * @param $instance
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function initialize($instance, ServiceLocatorInterface $serviceLocator)
    {

        if(!$instance instanceof RequiresZendAclInterface){
            return $instance;
        }
        if ($serviceLocator instanceof AbstractPluginManager)
        {
            $serviceLocator = $serviceLocator->getServiceLocator();
        }

        $user = $instance->getUser();
        if(empty($user)){
            $instance = parent::initialize($instance, $serviceLocator);
            $user = $instance->getUser();
        }

        /** @var ZendAcl $zendAcl */
        $zendAcl = $serviceLocator->get('Acl\Service\ZendAcl');
        $zendAcl->initAclForUser($user->getId());
        $instance->setZendAcl($zendAcl);

        return $instance;
    }
}