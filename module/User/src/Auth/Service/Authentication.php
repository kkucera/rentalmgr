<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 9/7/13
 */

namespace Auth\Service;

use Application\CrudServiceAbstract;
use Application\Logger\Factory as LoggerFactory;
use Application\ServiceLocator;
use Auth\Dao\Doctrine as AuthDao;
use Auth\Entity\Authentication as AuthenticationEntity;
use Auth\Exception\LoginFailed;
use DateTime;
use Logger;
use User\Entity\User;
use User\Service as UserService;
use Zend\ServiceManager\ServiceLocatorInterface;

class Authentication extends CrudServiceAbstract
{

    const TOKEN_NAME = 'auth_id';

    /**
     * @var string
     */
    private static $authId;

    /**
     * @var AuthenticationEntity
     */
    private static $authenticationEntity;

    /**
     * @var ServiceLocatorInterface
     */
    private $serviceLocator;

    /**
     * @var
     */
    private $userService;


    /**
     * @return Logger
     */
    protected function getLogger()
    {
        return LoggerFactory::get($this);
    }

    /**
     * @return AuthDao
     */
    public function getDao()
    {
        return $this->getInstanceDao('Auth\Dao\Doctrine');
    }

    /**
     * @return UserService
     */
    public function getUserService()
    {
        if(empty($this->userService)){
            $this->userService = new UserService();
        }
        return $this->userService;
    }

    /**
     * @param UserService $service
     */
    public function setUserService(UserService $service)
    {
        $this->userService = $service;
    }

    /**
     * @return ServiceLocatorInterface
     */
    public function getServiceLocator()
    {
        if(empty($this->serviceLocator)){
            $this->serviceLocator = new ServiceLocator();
        }
        return $this->serviceLocator;
    }

    /**
     * @return null|string
     */
    protected function getAuthIdFromCookie()
    {
        return $_COOKIE[self::TOKEN_NAME] ?: null;
    }

    /**
     * @param $authId
     */
    protected function setAuthCookie($authId)
    {
        setcookie(self::TOKEN_NAME, $authId, null, '/');
    }

    /**
     * Expire the session cookie
     */
    protected function expireAuthCookie()
    {
        setcookie(self::TOKEN_NAME, null, time()-1000, '/');
    }

    /**
     * Generates a unique id
     */
    protected function generateNewAuthId()
    {
        $prefix = $_SERVER["REMOTE_ADDR"] ?: rand(1,1000000);
        $id = md5(uniqid($prefix,true) . rand(1,1000000));
        return $id;
    }

    /**
     * @return AuthenticationEntity
     */
    protected function getNewAuthenticationEntity()
    {
        return new AuthenticationEntity();
    }

    /**
     * @param AuthenticationEntity $auth
     * @return object|void
     * @throws \RuntimeException
     */
    public function create(AuthenticationEntity $auth)
    {
        throw new \RuntimeException("Don't use session service create.  Use start.");
    }

    /**
     * @param $userId
     * @param bool $authenticated
     * @return object
     */
    public function start($userId, $authenticated = true)
    {
        $authId = $this->generateNewAuthId();
        $this->setAuthCookie($authId);
        $authEntity = $this->getNewAuthenticationEntity();
        $authEntity->setAuthenticationId($authId);
        $authEntity->setUserId($userId);
        $authEntity->setAuthenticated($authenticated);
        self::$authenticationEntity = $authEntity;
        return $this->save($authEntity);
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
     * @return null|AuthenticationEntity
     */
    public function getAuthentication()
    {
        if(self::$authenticationEntity){
            return self::$authenticationEntity;
        }

        $authId = $this->getAuthIdFromCookie();
        if($authId){
            /** @var AuthenticationEntity $auth */
            $auth = $this->load($authId);
            if($auth){
                if(($auth->getLastAccessed()->getTimestamp() + $this->getMaxLifetime()) > time()) {
                    self::$authenticationEntity = $auth;
                    return $auth;
                } else {
                    $this->delete($authId);
                }
            }
        }

        return null;
    }

    /**
     * @return User|null
     */
    public function getUser()
    {
        $auth = $this->getAuthentication();
        if($auth){
            $this->touchLastAccessed($auth);
            return $this->getUserService()->load($auth->getUserId());
        }
        return null;
    }

    /**
     * @return bool
     */
    public function logout() {
        $authEntity = $this->getAuthentication();
        if($authEntity){
            $this->getDao()->delete($authEntity);
            self::$authenticationEntity = null;
        }
        $this->expireAuthCookie();
        return true;
    }

    /**
     * Update the session lastAccessed date/time to the current time
     * @param null $authEntity
     */
    public function touchLastAccessed($authEntity = null)
    {
        $authEntity = $authEntity ?: $this->getAuthentication();
        $authEntity->setLastAccessed(new DateTime());
        $this->save($authEntity);
    }

    /**
     * @param ServiceLocatorInterface $serviceLocator
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

    /**
     * @param $username
     * @param $password
     * @return bool
     * @throws LoginFailed
     */
    public function validate($username, $password)
    {
        $userService = $this->getUserService();

        $user = $userService->getUserByUsername($username);
        if(empty($user)){
            throw new LoginFailed('User not found');
        }

        if($user->getPassword() !== $userService->encryptPassword($password)){
            throw new LoginFailed('Credentials are invalid.');
        }

        $this->start($user->getId());

        return true;
    }

    /**
     * @param $maxLifetime
     */
    public function removeOldAuthentications($maxLifetime = null)
    {

        if(empty($maxLifetime)){
            $maxLifetime = $this->getMaxLifetime();
        }

        /** @var \Auth\Dao\Doctrine $dao */
        $dao = $this->getDao();
        $dao->removeOldAuthentications($maxLifetime);
    }

}