<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 9/21/13
 */

namespace Acl\Service;

use Application\CrudServiceAbstract;
use Acl\Resource\AbstractResource;

class Resource extends CrudServiceAbstract{

    /**
     * Absolute class name of Dao to use for crud operations
     * @return string
     */
    protected function getDaoClassName()
    {
        return 'Acl\Dao\Doctrine\Resource';
    }

    public function save($resource)
    {
        if($resource instanceof AbstractResource){
            $resource = $resource->getEntity();
        }
        parent::save($resource);
    }

    public function deleteAllResources()
    {

    }
}