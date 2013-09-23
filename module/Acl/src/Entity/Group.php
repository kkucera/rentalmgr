<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 9/17/13
 */

namespace Acl\Entity;

use Acl\Entity\Permission;
use Doctrine\ORM\Mapping as ORM;
use DateTime;

/**
 * @ORM\Entity
 * @ORM\Table(name="acl_group")
 */
class Group {

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
    private $organizationId;

    /**
     * @ORM\Column(type="string", length=50)
     * @var
     */
    private $name;

    /**
     * @ORM\Column(type="datetime")
     * @var DateTime
     */
    private $created;

    /**
     * @ORM\ManyToMany(targetEntity="Permission")
     * @ORM\JoinTable(name="acl_group_permission",
     *      joinColumns={@ORM\JoinColumn(name="groupId", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="permissionId", referencedColumnName="id")}
     *      )
     * @var Permission[]
     **/
    private $permissions;

    public function __construct()
    {
        $this->setCreated(new DateTime('now'));
    }

    /**
     * @param \DateTime $created
     * @return Group
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
     * @return Group
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
     * @return Group
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
     * @param int $organizationId
     * @return Group
     */
    public function setOrganizationId($organizationId)
    {
        $this->organizationId = $organizationId;
        return $this;
    }

    /**
     * @return int
     */
    public function getOrganizationId()
    {
        return $this->organizationId;
    }

    /**
     * @param Permission[] $permissions
     * @return Group
     */
    public function setPermissions($permissions)
    {
        $this->permissions = $permissions;
        return $this;
    }

    /**
     * @return Permission[]
     */
    public function getPermissions()
    {
        return $this->permissions;
    }


}