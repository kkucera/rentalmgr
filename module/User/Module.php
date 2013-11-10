<?php
/**
 * Created by JetBrains PhpStorm.
 * User: kevin
 * Date: 8/29/13
 * Time: 9:07 PM
 * To change this template use File | Settings | File Templates.
 */

namespace User;

use Auth\Exception\UserNotAuthenticated;
use Auth\Service\RedirectCookie;
use Zend\Console\Request as ConsoleRequest;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Session\Container;

class Module {

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                    'Auth' => __DIR__ . '/src/Auth',
                ),
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getServiceConfig()
    {
        return include __DIR__ . '/config/service.config.php';
    }

    /**
     * @param MvcEvent $event
     */
    public function onBootstrap(MvcEvent $event)
    {
        $eventManager        = $event->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        $eventManager->getSharedManager()->attach('*', MvcEvent::EVENT_DISPATCH_ERROR, array($this, 'onDispatchError'), -90);
    }

    /**
     * @param MvcEvent $event
     */
    public function onDispatchError(MvcEvent $event)
    {
        /** @var \Zend\Http\PhpEnvironment\Request $request */
        $request = $event->getRequest();

        // just return on console requests
        if($request instanceof ConsoleRequest){
            return;
        }

        $result = $event->getResult();
        $exception = $result->exception;
        if($exception instanceof UserNotAuthenticated){
            /** @var \Zend\Http\PhpEnvironment\Response $response */
            $response=$event->getResponse();

            // set return cookie
            $requestUri = $request->getRequestUri();
            /** @var RedirectCookie $redirectCookieService */
            $redirectCookieService = $event->getApplication()->getServiceManager()->get('Auth\Service\RedirectCookie');
            $redirectCookieService->setResponseRedirectUri($response, $requestUri);

            $url = $event->getRouter()->assemble(array(), array('name' => 'auth-login'));
            $response->getHeaders()->addHeaderLine('Location', $url);
            $response->setStatusCode(302);
            $response->sendHeaders();
            return $response;
        }
    }
}