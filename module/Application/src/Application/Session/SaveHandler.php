<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 9/11/13
 */

namespace Application\Session;

use Application\Session\Service as SessionService;
use Application\Logger\Factory as LoggerFactory;
use Logger;
use Zend\Session\SaveHandler\SaveHandlerInterface;

class SaveHandler implements SaveHandlerInterface
{

    /**
     * @var SessionService
     */
    private $sessionService;

    /**
     * @return Logger
     */
    protected function getLogger()
    {
        return LoggerFactory::get($this);
    }

    /**
     * @param SessionService $sessionService
     * @return SaveHandler
     */
    public function setSessionService($sessionService)
    {
        $this->sessionService = $sessionService;
        return $this;
    }

    /**
     * @return SessionService
     */
    protected function getSessionService()
    {
        if(empty($this->sessionService)){
            $this->sessionService = new Service();
        }
        return $this->sessionService;
    }

    /**
     * @param $msg
     */
    protected function trace($msg)
    {
        $this->getLogger()->trace(__CLASS__.'::'.__FUNCTION__.' - '.$msg);
    }

    /**
     * Open Session - retrieve resources
     *
     * @param string $savePath
     * @param string $name
     */
    public function open($savePath, $name)
    {
        // do nothing
    }

    /**
     * Close Session - free resources
     *
     */
    public function close()
    {
        // do nothing
    }

    /**
     * Read session data
     *
     * @param string $id
     * @return string
     */
    public function read($id)
    {
        $this->trace("Reading Session [$id]");
        $sessionEntity = $this->getSessionService()->getSession($id);
        if($sessionEntity){
            $this->trace("Session data found");
            return $sessionEntity->getData();
        }
        $this->trace("No Session found");
        return '';
    }

    /**
     * Write Session - commit data to resource
     *
     * @param string $id
     * @param mixed $data
     */
    public function write($id, $data)
    {
        $this->trace("Writing Session [$id] $data");
        $sessionService = $this->getSessionService();
        $sessionEntity = $sessionService->getSession($id);
        if(empty($sessionEntity)){
            $this->trace("Existing session record not found creating new.");
            $sessionEntity = $sessionService->getNewSessionEntity();
            $sessionEntity->setSessionId($id);
        }
        $sessionEntity->setData($data);
        $sessionService->save($sessionEntity);
    }

    /**
     * Destroy Session - remove data from resource for
     * given session id
     *
     * @param string $id
     */
    public function destroy($id)
    {
        $this->trace("Destroying Session [$id]");
        $this->getSessionService()->delete($id);
    }

    /**
     * Garbage Collection - remove old session data older
     * than $maxlifetime (in seconds)
     *
     * @param int $maxlifetime
     */
    public function gc($maxlifetime)
    {
        $this->getSessionService()->removeOldSessions($maxlifetime);
    }
}