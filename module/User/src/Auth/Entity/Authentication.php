<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 9/8/13
 */

namespace Auth\Entity;

use Doctrine\ORM\Mapping as ORM;
use DateTime;

/**
 * @ORM\Entity
 * @ORM\Table(name="authentication")
 */
class Authentication {

    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=32)
     * @var string
     */
    private $authenticationId;

    /**
     * @ORM\Column(type="datetime")
     * @var DateTime
     */
    private $lastAccessed;

    /**
     * @ORM\Column(type="boolean")
     * @var bool
     */
    private $authenticated;

    /**
     * @ORM\Column(type="integer")
     * @var
     */
    private $userId;

    /**
     * Construct and set defaults
     */
    public function __construct()
    {
        $this->setAuthenticated(false);
        $this->setLastAccessed(new DateTime());
    }

    /**
     * @param \DateTime $lastAccessed
     * @return Authentication
     */
    public function setLastAccessed($lastAccessed)
    {
        $this->lastAccessed = $lastAccessed;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getLastAccessed()
    {
        return $this->lastAccessed;
    }

    /**
     * @param string $sessionId
     * @return Authentication
     */
    public function setAuthenticationId($sessionId)
    {
        $this->authenticationId = $sessionId;
        return $this;
    }

    /**
     * @return string
     */
    public function getAuthenticationId()
    {
        return $this->authenticationId;
    }

    /**
     * @param boolean $authenticated
     * @return Authentication
     */
    public function setAuthenticated($authenticated)
    {
        $this->authenticated = $authenticated;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isAuthenticated()
    {
        return $this->authenticated;
    }

    /**
     * @param mixed $userId
     * @return Authentication
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }


}