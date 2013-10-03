<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 9/21/13
 */

namespace Acl\Dao\Doctrine;


use Application\Dao\DoctrineCrud;

class Resource extends DoctrineCrud {

    /**
     * This is the class name of the model this dao works with
     * @return string
     */
    public function getEntityName()
    {
        return 'Acl\Entity\Resource';
    }

    public function deleteAllResources()
    {
        $em = $this->getEntityManager();
        $conn = $this->getEntityManager()->getConnection();
        $conn->exec('SET foreign_key_checks = 0');
        $result = $em->createQuery('DELETE FROM \Acl\Entity\Resource')->execute();
        $conn->exec('SET foreign_key_checks = 1');
        return $result;
    }

}