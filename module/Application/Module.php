<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Application\Dto\ErrorResponse;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\View\Model\JsonModel;
use Zend\Http\PhpEnvironment\Response;
use Zend\Http\PhpEnvironment\Request;

class Module
{

    /**
     * @param $uri
     * @return bool
     */
    protected function isService($uri)
    {
        return strpos($uri,'/service/') !== false;
    }

    /**
     * @return ErrorResponse
     */
    protected function getErrorResponse()
    {
        return new ErrorResponse();
    }

    /**
     * @return array
     */
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__
                ),
            ),
        );
    }

    /**
     * @return mixed
     */
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    /**
     * @return mixed
     */
    public function getServiceConfig()
    {
        return include __DIR__ . '/config/service.config.php';
    }

    /**
     * @param MvcEvent $e
     */
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        $eventManager->getSharedManager()->attach('*', MvcEvent::EVENT_DISPATCH_ERROR, array($this, 'onDispatchError'), -100);

    }

    /**
     * Look for a valid format from the requested uri
     * @param $requestUri
     * @return string
     */
    protected function getFormatFromUri($requestUri)
    {
        $validFormats = array('.json', '.xml');
        foreach($validFormats as $format){
            if(strpos($requestUri, $format) !== false){
                return trim($format, '.');
            }
        }
        return '';
    }

    /**
     * Get the requested format.  Try route match, if not available inspect uri.
     * @param MvcEvent $event
     * @return mixed|string
     */
    protected function getFormat(MvcEvent $event)
    {
        $routeMatch = $event->getRouteMatch();
        if($routeMatch){
            $format = $routeMatch->getParam('format');
        }else{
            /** @var \Zend\Http\PhpEnvironment\Request $request */
            $request = $event->getRequest();
            $format = $this->getFormatFromUri($request->getRequestUri());
        }
        return $format;
    }

    /**
     * @param MvcEvent $event
     */
    public function onDispatchError(MvcEvent $event)
    {
        /** @var \Zend\Http\PhpEnvironment\Response $response */
        $response = $event->getResponse();
        /** @var \Zend\Http\PhpEnvironment\Request $request */
        $request = $event->getRequest();

        $requestUri = $request->getRequestUri();

        $format = $this->getFormat($event);

        if($format === 'json'){
            $result = $event->getResult();
            $errorResponse = $this->getErrorResponse();
            $errorResponse
                ->setStatusCode($response->getStatusCode())
                ->setMessage($result->message)
                ->setException($result->exception)
                ->setUri($requestUri);

            $event->setViewModel(new JsonModel($errorResponse->getResponseArray()));
        }

        // TODO: setup log4php & log if response code is not 0

    }
}
