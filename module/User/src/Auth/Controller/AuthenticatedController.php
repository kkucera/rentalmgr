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
use Application\Controller\AbstractController;
use Auth\Service\RedirectCookie;
use User\Entity\User;
use Zend\Http\Header\SetCookie;
use Zend\Mvc\MvcEvent;

class AuthenticatedController extends AbstractController
{
    /**
     * @var User
     */
    private $user;

    /**
     * Checks if the user has the required permission
     * @param $permissionId
     * @throws \Acl\Exception\PermissionDenied
     */
    protected function userHasPermission($permissionId)
    {
        $this->getPermissionService()->requirePermissionId($permissionId, $this->user->getId());
    }

    /**
     * @return \Acl\Service\Permission
     */
    protected function getPermissionService()
    {
        return $this->getServiceLocator()->get('Acl\Service\Permission');
    }

    /**
     * @return \Auth\Service\Authentication
     */
    protected function getAuthService()
    {
        return $this->getServiceLocator()->get('Auth\Service\Authentication');
    }

    /**
     * @return RedirectCookie
     */
    protected function getRedirectCookieService()
    {
        return $this->getServiceLocator()->get('Auth\Service\RedirectCookie');
    }

    /**
     * @param MvcEvent $event
     * @return \Zend\Http\Response
     */
    protected function redirectToLogin(MvcEvent $event)
    {
        /** @var \Zend\Http\PhpEnvironment\Request $request */
        $request = $event->getRequest();
        $requestUri = $request->getRequestUri();
        $response = $this->redirect()->toRoute('auth-login',array('controller'=>'login'));
        return $this->getRedirectCookieService()->setResponseRedirectUri($response, $requestUri);
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
     * @param MvcEvent $event
     * @return mixed|\Zend\Http\Response
     */
    public function onDispatch(MvcEvent $event)
    {
        $authService = $this->getAuthService();
        $user = $authService->getUser();
        if(empty($user)){
            return $this->redirectToLogin($event);
        }
        $this->setUser($user);
        $this->layout('layout/authenticated');
        return parent::onDispatch($event);
    }

}