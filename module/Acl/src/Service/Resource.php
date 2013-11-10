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
use Acl\Entity\Resource as ResourceEntity;
use Acl\Exception\InvalidResourceName;
use Acl\Exception\RecursiveResourceRelationship;
use Acl\Resource\AbstractResource;
use Acl\Resource\Factory as ResourceFactory;
use Application\ServiceLocator;
use Acl\Dao\Doctrine\Resource as ResourceDao;

class Resource extends CrudServiceAbstract
{

    /**
     * @var ResourceFactory
     */
    private $resourceFactory;

    /**
     * @param ResourceFactory $resourceFactory
     */
    public function __construct(ResourceFactory $resourceFactory)
    {
        $this->resourceFactory = $resourceFactory;
    }

    /**
     * @return ResourceDao
     */
    public function getDao()
    {
        return $this->getInstanceDao('Acl\Dao\Doctrine\Resource');
    }

    /**
     * Deletes all resources from the database
     */
    public function deleteAllResources()
    {
        $this->getDao()->deleteAll();
    }

}