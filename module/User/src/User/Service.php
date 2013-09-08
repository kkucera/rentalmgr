<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 9/1/13
 */

namespace User;

use Application\ServiceLocator;
use Application\CrudServiceAbstract;

class Service extends CrudServiceAbstract
{

    /**
     * @return string
     */
    protected function getDaoClassName()
    {
        return 'User\Dao\Doctrine';
    }

}