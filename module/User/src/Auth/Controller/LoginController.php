<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 9/7/13
 */

namespace Auth\Controller;

use Application\Controller\AbstractController;
use Auth\Exception\LoginFailed;
use Auth\Service\RedirectCookie;
use Zend\Http\Header\SetCookie;
use Zend\Http\PhpEnvironment\Request;
use Zend\View\Model\ViewModel;

class LoginController extends AbstractController
{

    /**
     * @return \Auth\Service\Authentication
     */
    protected function getAuthService()
    {
        return $this->getServiceLocator()->get('Auth\Service\Authentication');
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
     * @return RedirectCookie
     */
    protected function getRedirectCookieService()
    {
        return $this->getServiceLocator()->get('Auth\Service\RedirectCookie');
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
            return $this->redirect()->toRoute('auth-login',array('controller'=>'login'));
        }

        return $this->getRedirectResponse($request);
    }

    public function logoutAction()
    {
        /** @var \Zend\Http\PhpEnvironment\Request $request */
        $request = $this->getRequest();
        $data = $request->getPost();
        $logoutMessage = $data['message'] ?: 'OK. You have been logged out.';
        $authService = $this->getAuthService();
        $authService->logout();
        $this->flashMessenger()->addMessage($logoutMessage);
        return $this->redirect()->toRoute('auth-login',array('controller'=>'login'));
    }
}