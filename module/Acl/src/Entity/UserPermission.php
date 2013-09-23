<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 8/31/13
 */

namespace Acl\Entity;

use Doctrine\ORM\Mapping as ORM;
use DateTime;

/**
 * @ORM\Entity
 * @ORM\Table(name="acl_user_permission", indexes={@ORM\index(name="userId", columns={"userId"} ) } )
 */
class UserPermission {

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    private $userId;

    /**
     * @ORM\OneToOne(targetEntity="Permission")
     * @ORM\JoinColumn(name="permissionId", referencedColumnName="id")
     * @var Permission
     */
    private $permission;

    /**
     * @ORM\Column(type="datetime")
     * @var DateTime
     */
    private $created;

    public function __construct()
    {
        $this->setCreated(new DateTime('now'));
    }

    /**
     * @param \DateTime $created
     * @return UserPermission
     */
    public function setCreated($created)
    {
        $this->created = $created;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param int $id
     * @return UserPermission
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param \Acl\Entity\Permission $permission
     * @return UserPermission
     */
    public function setPermission($permission)
    {
        $this->permission = $permission;
        return $this;
    }

    /**
     * @return \Acl\Entity\Permission
     */
    public function getPermission()
    {
        return $this->permission;
    }

    /**
     * @param int $userId
     * @return UserPermission
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
        return $this;
    }

    /**
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }


}