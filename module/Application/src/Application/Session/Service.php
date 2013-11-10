<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 9/8/13
 */

namespace Application\Session;

use Application\CrudServiceAbstract;
use Application\Logger\Factory as LoggerFactory;
use Application\Session\Dao\Doctrine as SessionDao;
use Application\Session\Entity\Session as SessionEntity;
use DateTime;
use Logger;

class Service extends CrudServiceAbstract
{

    /**
     * @return string
     */
    protected function getDaoClassName()
    {
        return 'Application\Session\Dao\Doctrine';
    }

    /**
     * @return Logger
     */
    protected function getLogger()
    {
        return LoggerFactory::get($this);
    }

    /**
     * @param $msg
     */
    protected function trace($msg)
    {
        $this->getLogger()->trace(__CLASS__.'::'.__FUNCTION__.' - '.$msg);
    }

    /**
     * @return SessionDao
     */
    public function getDao()
    {
        return $this->getInstanceDao('Application\Session\Dao\Doctrine');
    }

    /**
     * @return SessionEntity
     */
    public function getNewSessionEntity()
    {
        return new SessionEntity();
    }

    /**
     * Get the max session life time in seconds from the config
     * for now just returning 1 hour
     */
    public function getMaxLifetime()
    {
        return 360;
    }

    /**
     * @param SessionEntity $session
     * @return bool
     */
    protected function isSessionExpired(SessionEntity $session)
    {
        return ($session->getLastModified()->getTimestamp() + $this->getMaxLifetime()) <= time();
    }

    /**
     * @param SessionEntity $session
     * @return object
     */
    public function save(SessionEntity $session)
    {
        $session->setLastModified(new DateTime());
        return parent::save($session);
    }

    /**
     * @param $sessionId
     * @return null|SessionEntity
     */
    public function getSession($sessionId)
    {
        if($sessionId){
            $session = $this->load($sessionId);
            if($session){
                if(!$this->isSessionExpired($session)) {
                    $this->trace("Valid Session found [$sessionId]");
                    return $session;
                } else {
                    $this->trace("Session found but expired [$sessionId]");
                    $this->delete($sessionId)->flush();
                    return null;
                }
            }
        }

        return null;
    }

    /**
     * @param $maxLifetime
     */
    public function removeOldSessions($maxLifetime = null)
    {

        if(empty($maxLifetime)){
            $maxLifetime = $this->getMaxLifetime();
        }

        /** @var \Application\Session\Dao\Doctrine $dao */
        $dao = $this->getDao();
        $dao->removeOldSessions($maxLifetime);
    }
}