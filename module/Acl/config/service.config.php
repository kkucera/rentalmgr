<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 9/2/13
 */
namespace Acl;

use Acl\Service\Permission;
use Zend\ServiceManager\ServiceManager;

return array(
    'factories' => array(
        'Acl\Service\Permission' => function(ServiceManager $sm){
            $permissionService = new Permission();
            $permissionService->setServiceLocator($sm);
            return $permissionService;
        },
    ),
    'services' => array(
        'Acl\Service\Resource' => new Service\Resource,
        'Acl\Service\UserPermission' => new Service\UserPermission,
        'Acl\Service\UserGroup' => new Service\UserGroup,
        'Acl\Service\Group' => new Service\Group,
        'Acl\Service\ZendAcl' => new Service\ZendAcl,
    )
);