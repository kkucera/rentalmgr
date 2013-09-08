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
use User\Auth\Exception\LoginFailed;
use User\Auth\RedirectCookieService;
use Zend\Http\Header\SetCookie;
use Zend\Http\PhpEnvironment\Request;
use Zend\View\Model\ViewModel;

class LoginController extends AbstractController
{

    /**
     * @return \User\Auth\Service
     */
    protected function getAuthService()
    {
        return $this->getServiceLocator()->get('User\Auth\Service');
    }

    /**
     * @return array
     */
    protected function getMessages()
    {
        $flashMessenger = $this->flashMessenger();
        $messages = array();
        if ($flashMessenger->hasMessages()) {
            $messages = $flashMessenger->getMessages();
        }
        return $messages;
    }

    /**
     * @return RedirectCookieService
     */
    protected function getRedirectCookieService()
    {
        return $this->getServiceLocator()->get('User\Auth\RedirectCookieService');
    }

    /**
     * @param Request $request
     * @return string|null
     */
    protected function getRedirectUri(Request $request)
    {
        $uri = $this->getRedirectCookieService()->getRedirectUri($request);
        return $uri ?: '/property';
    }

    /**
     * @param Request $request
     * @return \Zend\Http\Response
     */
    protected function getRedirectResponse(Request $request)
    {
        $redirectUri = $this->getRedirectUri($request);
        $response = $this->redirect()->toUrl($redirectUri);
        return $this->getRedirectCookieService()->removeRedirectUri($response);
    }

    public function indexAction()
    {
        return new ViewModel(array(
            'messages' => $this->getMessages(),
        ));
    }

    public function authenticateAction()
    {
        /** @var \Zend\Http\PhpEnvironment\Request $request */
        $request = $this->getRequest();
        $data = $request->getPost();
        $username = $data['username'];
        $password = $data['password'];

        $authService = $this->getAuthService();
        try{
            $authService->validate($username, $password);
        }catch(LoginFailed $ex){
            $this->flashMessenger()->addMessage($ex->getMessage());
            return $this->redirect()->toRoute('user-login',array('controller'=>'login'));
        }

        return $this->getRedirectResponse($request);
    }

    public function logoutAction()
    {
        $authService = $this->getAuthService();
        $authService->logout();
        $this->flashMessenger()->addMessage('OK. You have been logged out.');
        return $this->redirect()->toRoute('user-login',array('controller'=>'login'));
    }
}