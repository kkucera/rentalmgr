<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 11/20/13
 */

namespace Organization\Entity;

use Doctrine\ORM\Mapping as ORM;
use DateTime;

/**
 * @ORM\Entity
 * @ORM\Table(name="organization")
 */
class Organization
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @var
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity="Core\Entity\Address")
     * @ORM\JoinTable(name="organization_address",
     *      joinColumns={@ORM\JoinColumn(name="organizationId", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="addressId", referencedColumnName="id")}
     *      )
     * @var \Core\Entity\Address[]
     **/
    private $addresses;

    /**
     * @ORM\ManyToMany(targetEntity="Core\Entity\Phone")
     * @ORM\JoinTable(name="organization_phone",
     *      joinColumns={@ORM\JoinColumn(name="organizationId", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="phoneId", referencedColumnName="id")}
     *      )
     * @var \Core\Entity\Phone[]
     **/
    private $phones;

    /**
     * @ORM\Column(type="datetime")
     * @var DateTime
     */
    private $created;

    /**
     * @ORM\Column(type="datetime")
     * @var DateTime
     */
    private $modified;

    /**
     *
     */
    public function __construct()
    {
        $this->setCreated(new DateTime());
        $this->setModified(new DateTime());
    }

    /**
     * @param \Core\Entity\Address[] $addresses
     * @return Organization
     */
    public function setAddresses($addresses)
    {
        $this->addresses = $addresses;
        return $this;
    }

    /**
     * @return int
     */
    public function getAddressCount()
    {
        return count($this->addresses);
    }

    /**
     * @return \Core\Entity\Address[]
     */
    public function getAddresses()
    {
        return $this->addresses;
    }

    /**
     * @param $index
     * @return \Core\Entity\Address|null
     */
    public function getAddress($index)
    {
        if(!isset($this->addresses[$index])){
            return null;
        }
        return $this->addresses[$index];
    }


    /**
     * @param \DateTime $created
     * @return Organization
     */
    public function setCreated($created)
    {
        $this->created = $created;
        return $this;
    }

    /**
     * Return the created date time object or a string formated as requested
     * @param null $format
     * @return DateTime|string
     */
    public function getCreated($format = null)
    {
        if($format){
            return $this->created->format($format);
        }
        return $this->created;
    }

    /**
     * @param int $id
     * @return Organization
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
     * @return Organization
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
     * @param \Core\Entity\Phone[] $phones
     * @return Organization
     */
    public function setPhones($phones)
    {
        $this->phones = $phones;
        return $this;
    }

    /**
     * @return int
     */
    public function getPhoneCount()
    {
        return count($this->phones);
    }

    /**
     * @return \Core\Entity\Phone[]
     */
    public function getPhones()
    {
        return $this->phones;
    }

    /**
     * @param $index
     * @return \Core\Entity\Phone|null
     */
    public function getPhone($index)
    {
        if(!isset($this->phones[$index])){
            return null;
        }
        return $this->phones[$index];
    }

    /**
     * @param \DateTime $modified
     * @return Organization
     */
    public function setModified($modified)
    {
        $this->modified = $modified;
        return $this;
    }

    /**
     * Return the modified date time object or a string formated as requested
     * @param null $format
     * @return DateTime|string
     */
    public function getModified($format = null)
    {
        if($format){
            return $this->modified->format($format);
        }
        return $this->modified;
    }

}