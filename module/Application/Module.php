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
use Application\Logger\Factory as LoggerFactory;
use Logger;
use Zend\Console\Request as ConsoleRequest;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Session\Container;
use Zend\Session\SessionManager;
use Zend\View\Model\JsonModel;
use Zend\Http\PhpEnvironment\Response;
use Zend\Http\PhpEnvironment\Request;

class Module
{

    /**
     * @return ErrorResponse
     */
    protected function getErrorResponse()
    {
        return new ErrorResponse();
    }

    /**
     * @return Logger
     */
    protected function getLogger()
    {
        return LoggerFactory::get($this);
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
     * @param MvcEvent $event
     */
    public function onBootstrap(MvcEvent $event)
    {
        $eventManager        = $event->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        ServiceLocator::register($event->getApplication()->getServiceManager());

        $eventManager->getSharedManager()->attach('*', MvcEvent::EVENT_DISPATCH_ERROR, array($this, 'onDispatchError'), -100);

        Logger::configure();

        $serviceLocator = $event->getApplication()->getServiceManager();
        $saveHandler = $serviceLocator->get('Application\Service\SaveHandler');
        $manager = new SessionManager();
        $manager->setSaveHandler($saveHandler);
        Container::setDefaultManager($manager);
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

        // just return on console requests
        if($request instanceof ConsoleRequest){
            return;
        }

        $requestUri = $request->getRequestUri();

        $format = $this->getFormat($event);

        $result = $event->getResult();
        $errorResponse = $this->getErrorResponse();
        $errorResponse
            ->setStatusCode($response->getStatusCode())
            ->setMessage($result->message)
            ->setException($result->exception)
            ->setUri($requestUri);

        if($format === 'json'){
            $event->setViewModel(new JsonModel($errorResponse->getResponseArray()));
        }

        if($response->getStatusCode() !== 0){
            $this->getLogger()->error($errorResponse);
        }

    }

}
