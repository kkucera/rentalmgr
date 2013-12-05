<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 9/7/13
 */

namespace Auth\Controller;

use Acl\Exception\PermissionDenied;
use Acl\Initializer\Interfaces\RequiresZendAclInterface;
use Acl\Service\ZendAcl;
use Application\Controller\AbstractController;
use User\Entity\User;
use Zend\Http\Header\SetCookie;
use Zend\Mvc\MvcEvent;
use Zend\View\Helper\Navigation\AbstractHelper as Navigation;

class AuthenticatedController extends AbstractController implements RequiresZendAclInterface
{
    /**
     * @var User
     */
    private $user;

    /**
     * @var ZendAcl
     */
    private $zendAcl;

    /**
     * @return \Auth\Service\Authentication
     */
    protected function getAuthService()
    {
        return $this->getServiceLocator()->get('Auth\Service\Authentication');
    }

    /**
     * Checks if the user has the required resource
     * @param $resourceName
     * @throws \Acl\Exception\PermissionDenied
     */
    protected function requireResource($resourceName)
    {
        if(!$this->getZendAcl()->userHasResource($this->user->getId(), $resourceName)){
            throw new PermissionDenied('User does not have access to resource: ['.$resourceName.']');
        }
    }

    /**
     * @param ZendAcl $zendAcl
     * @param $userId
     */
    protected function registerZendAclWithNavigation(ZendAcl $zendAcl, $userId)
    {
        // Set default navigation ACL and role statically:
        Navigation::setDefaultAcl($zendAcl);
        Navigation::setDefaultRole("user:$userId");
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return int
     */
    protected function getSessionTimeOut()
    {
        $authService = $this->getAuthService();
        return $authService->getMaxLifetime();
    }

    /**
     * @param MvcEvent $event
     * @return mixed|\Zend\Http\Response
     */
    public function onDispatch(MvcEvent $event)
    {
        $user = $this->getUser();
        $this->registerZendAclWithNavigation($this->getZendAcl(), $user->getId());

        $this->layout('layout/authenticated');
        $this->layout()->setVariable('userName', $user->getName());
        $this->layout()->setVariable('userId', $user->getId());
        $this->layout()->setVariable('autoLoggoutTimeOut', $this->getSessionTimeOut());
        return parent::onDispatch($event);
    }

    /**
     * @param ZendAcl $acl
     * @return mixed
     */
    public function setZendAcl(ZendAcl $acl)
    {
        $this->zendAcl = $acl;
    }

    /**
     * @return ZendAcl
     */
    public function getZendAcl()
    {
        return $this->zendAcl;
    }
}