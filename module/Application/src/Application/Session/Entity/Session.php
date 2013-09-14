<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 9/8/13
 */

namespace Application\Session\Entity;

use Doctrine\ORM\Mapping as ORM;
use DateTime;

/**
 * @ORM\Entity
 * @ORM\Table(name="session")
 */
class Session {

    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=32)
     * @var string
     */
    private $sessionId;

    /**
     * @ORM\Column(type="datetime")
     * @var DateTime
     */
    private $lastModified;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @var string
     */
    private $data;

    /**
     * Construct and set defaults
     */
    public function __construct()
    {
        $this->setLastModified(new DateTime());
    }

    /**
     * @param \DateTime $lastModified
     * @return Session
     */
    public function setLastModified($lastModified)
    {
        $this->lastModified = $lastModified;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getLastModified()
    {
        return $this->lastModified;
    }

    /**
     * @param string $sessionId
     * @return Session
     */
    public function setSessionId($sessionId)
    {
        $this->sessionId = $sessionId;
        return $this;
    }

    /**
     * @return string
     */
    public function getSessionId()
    {
        return $this->sessionId;
    }

    /**
     * @param string $data
     * @return Session
     */
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * @return string
     */
    public function getData()
    {
        return $this->data;
    }

}