<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 9/18/13
 */

namespace Acl\Entity;

use Acl\Entity\Resource as ResourceEntity;
use Doctrine\ORM\Mapping as ORM;
use DateTime;

/**
 * @ORM\Entity
 * @ORM\Table(name="acl_permission")
 */
class Permission {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @var int
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Resource", inversedBy="permissions")
     * @ORM\JoinColumn(name="resourceId", referencedColumnName="id")
     * @var ResourceEntity
     */
    private $resource;

    /**
     * @ORM\Column(type="string", length=50)
     * @var string
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     * @var string
     */
    private $description;

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
     * @return Permission
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
     * @param string $description
     * @return Permission
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param int $id
     * @return Permission
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
     * @param string $name
     * @return Permission
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param ResourceEntity $resource
     * @return Permission
     */
    public function setResource(ResourceEntity $resource)
    {
        $this->resource = $resource;
        return $this;
    }

    /**
     * @return ResourceEntity
     */
    public function getResource()
    {
        return $this->resource;
    }

}