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
 * @ORM\Table(name="acl_user_resource", indexes={@ORM\index(name="userId", columns={"userId"} ) } )
 */
class UserResource {

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
     * @ORM\OneToOne(targetEntity="Resource")
     * @ORM\JoinColumn(name="resourceId", referencedColumnName="id")
     * @var Resource
     */
    private $resource;

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
     * @return UserResource
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
     * @return UserResource
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
     * @param \Acl\Entity\Resource $resource
     * @return UserResource
     */
    public function setResource($resource)
    {
        $this->resource = $resource;
        return $this;
    }

    /**
     * @return \Acl\Entity\Resource
     */
    public function getResource()
    {
        return $this->resource;
    }

    /**
     * @param int $userId
     * @return UserResource
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