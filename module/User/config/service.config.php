<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 9/2/13
 */
namespace User;

return array(
    'factories' => array(
        'User\Auth\Service' => function($sm){
            $service = new Auth\Service();
            $service->setServiceLocator($sm);
            return $service;
        },
    ),
    'services' => array(
        'User\Auth\RedirectCookieService' => new Auth\RedirectCookieService()
    )
);