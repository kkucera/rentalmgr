<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 9/17/13
 */

namespace Acl\Entity;

use Doctrine\ORM\Mapping as ORM;
use DateTime;

/**
 * @ORM\Entity
 * @ORM\Table(name="acl_user_group", indexes={ @ORM\index(name="userId", columns={"userId"}) } )
 */
class UserGroup {

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
     * @ORM\OneToOne(targetEntity="Group")
     * @ORM\JoinColumn(name="groupId", referencedColumnName="id")
     * @var Group
     */
    private $group;

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
     * @return UserGroup
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
     * @param \Acl\Entity\Group $group
     * @return UserGroup
     */
    public function setGroup($group)
    {
        $this->group = $group;
        return $this;
    }

    /**
     * @return \Acl\Entity\Group
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * @param int $id
     * @return UserGroup
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
     * @param int $userId
     * @return UserGroup
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