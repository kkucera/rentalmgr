<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 9/1/13
 */

namespace Books\Expense;

use Application\CrudServiceAbstract;

class Service extends CrudServiceAbstract
{

    /**
     * Absolute class name of Dao to use for crud operations
     * @return string
     */
    protected function getDaoClassName()
    {
        return 'Books\Expense\Dao\Doctrine';
    }

}