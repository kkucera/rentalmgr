<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 9/20/13
 */

namespace Acl\Entity;

use Doctrine\ORM\Mapping as ORM;
use DateTime;

/**
 * @ORM\Entity
 * @ORM\Table(name="acl_resource")
 */
class Resource {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @var string
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=256)
     * @var string
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity="Permission", mappedBy="resourceId")
     * @var Permission[]
     */
    private $permissions;

    /**
     * @ORM\ManyToOne(targetEntity="Resource")
     * @ORM\JoinColumn(name="parentId", referencedColumnName="id")
     * @var Resource
     */
    private $parent;

    /**
     * @ORM\Column(type="string", length=128)
     * @var string
     */
    private $class;

    /**
     * @param mixed $description
     * @return Resource
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param int $id
     * @return Resource
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
     * @param mixed $name
     * @return Resource
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param \Acl\Entity\Permission[] $permissions
     * @return Resource
     */
    public function setPermissions($permissions)
    {
        $this->permissions = $permissions;
        return $this;
    }

    /**
     * @return \Acl\Entity\Permission[]
     */
    public function getPermissions()
    {
        return $this->permissions;
    }

    /**
     * @param Resource $parent
     * @return Resource
     */
    public function setParent($parent)
    {
        $this->parent = $parent;
        return $this;
    }

    /**
     * @return Resource
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param string $class
     * @return Resource
     */
    public function setClass($class)
    {
        $this->class = $class;
        return $this;
    }

    /**
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }

}