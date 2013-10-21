<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 9/2/13
 */
namespace Application;

use Application\Dao\DoctrineFactory;
use Zend\ServiceManager\ServiceManager;

return array(
    'factories' => array(
        'navigation' => 'Zend\Navigation\Service\DefaultNavigationFactory',
    ),
    'services' => array(
        'Application\Service\SaveHandler' => new Session\SaveHandler,
        'Application\Dao\DoctrineFactory' => new DoctrineFactory,
    )
);