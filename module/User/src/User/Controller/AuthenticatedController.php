<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 9/7/13
 */

namespace User\Controller;

use Application\Controller\AbstractController;
use User\Auth\RedirectCookieService;
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
     * @return \User\Auth\Service
     */
    protected function getAuthService()
    {
        return $this->getServiceLocator()->get('User\Auth\Service');
    }

    /**
     * @return RedirectCookieService
     */
    protected function getRedirectCookieService()
    {
        return $this->getServiceLocator()->get('User\Auth\RedirectCookieService');
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
        $response = $this->redirect()->toRoute('user-login',array('controller'=>'login'));
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
        return parent::onDispatch($event);
    }

}