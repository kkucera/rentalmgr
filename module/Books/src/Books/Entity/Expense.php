<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 8/31/13
 */

namespace Books\Entity;

use Books\Entity\ExpenseCategory;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Property\Entity\Property;

/**
 * @ORM\Entity
 * @ORM\Table(name="expense")
 */
class Expense {

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     * @var int
     */
    private $date;

    /**
     * @ORM\Column(type="decimal")
     * @var float
     */
    private $amount;

    /**
     * @ORM\ManyToOne(targetEntity="ExpenseCategory")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     * @var ExpenseCategory
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity="Property\Entity\Property")
     * @ORM\JoinColumn(name="property_id", referencedColumnName="id")
     * @var Property
     */
    private $property;

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
     * @param float $amount
     * @return Expense
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param \Books\Entity\ExpenseCategory $category
     * @return Expense
     */
    public function setCategory($category)
    {
        $this->category = $category;
        return $this;
    }

    /**
     * @return \Books\Entity\ExpenseCategory
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param \DateTime $created
     * @return Expense
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
     * @param int $date
     * @return Expense
     */
    public function setDate($date)
    {
        $this->date = $date;
        return $this;
    }

    /**
     * @return int
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param int $id
     * @return Expense
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
     * @param \Property\Entity\Property $property
     * @return Expense
     */
    public function setProperty($property)
    {
        $this->property = $property;
        return $this;
    }

    /**
     * @return \Property\Entity\Property
     */
    public function getProperty()
    {
        return $this->property;
    }

    /**
     * @param \DateTime $modified
     * @return Expense
     */
    public function setModified($modified)
    {
        $this->modified = $modified;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getModified()
    {
        return $this->modified;
    }


}