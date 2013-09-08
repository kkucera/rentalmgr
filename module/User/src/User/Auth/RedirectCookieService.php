<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 9/7/13
 */

namespace User\Auth;

use Zend\Http\Header\SetCookie;
use Zend\Http\Response;
use Zend\Http\PhpEnvironment\Request;

class RedirectCookieService {

    /**
     * @var string
     */
    private $cookieName = 'redirectUri';

    /**
     * @return SetCookie
     */
    protected function getRedirectCookie()
    {
        return new SetCookie($this->getCookieName(), null, null, '/');
    }

    /**
     * @return string
     */
    public function getCookieName()
    {
        return $this->cookieName;
    }

    /**
     * @param Request $request
     * @return string|null
     */
    public function getRedirectUri(Request $request)
    {
        $redirectCookie = $request->getCookie();
        $cookieValues = $redirectCookie->getArrayCopy();
        return $cookieValues[$this->getCookieName()] ?: null;
    }

    /**
     * @param Response $response
     * @param $uri
     * @return Response
     */
    public function setResponseRedirectUri(Response $response, $uri)
    {
        if(!empty($uri)){
            $cookie = $this->getRedirectCookie();
            $cookie->setValue($uri);
            $response->getHeaders()->addHeader($cookie);
        }
        return $response;
    }

    /**
     * @param Response $response
     * @return Response
     */
    public function removeRedirectUri(Response $response)
    {
        $cookie = $this->getRedirectCookie();
        $cookie->setExpires(time() - 1000);
        $response->getHeaders()->addHeader($cookie);
        return $response;
    }

}