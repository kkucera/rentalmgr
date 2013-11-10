<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 10/26/13
 */
namespace Core\Initializer;

use Core\Exception\Dependency;
use Core\Initializer\Interfaces\InjectViaInitializerInterface;
use ReflectionClass;
use ReflectionMethod;
use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\InitializerInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Core\Initializer\Helper\Injection as InjectionHelper;

/**
 * Uses reflection to detect the dependency type, injects it into the depender instance.
 *
 * @category: Kevin Kucera
 * @package: Core
 * @copyright: Copyright (c) 2013 Kevin Kucera
 */
class InterfaceInjection implements InitializerInterface
{

    /**
     * @var InjectionHelper
     */
    private $injectionHelper;

    /**
     * @var string[]
     */
    private $injectionInterfaces = array(
        'Core\Initializer\Interfaces\InjectViaInitializerInterface'
    );

    /**
     * @param InjectViaInitializerInterface $instance
     * @return bool
     */
    public function canInitialize($instance)
    {
        return $this->getInjectionHelper()->isInstanceOf($instance, $this->injectionInterfaces);
    }

    /**
     * @param $interfaceName
     * @return bool
     */
    protected function canInitializeInterface($interfaceName)
    {
        return $this->getInjectionHelper()->isSubclassOf($interfaceName, $this->injectionInterfaces);
    }

    /**
     * Initialize
     *
     * @param InjectViaInitializerInterface $instance
     * @param ServiceLocatorInterface $serviceLocator
     * @throws Dependency
     * @return void
     */
    public function initialize($instance, ServiceLocatorInterface $serviceLocator)
    {
//        echo PHP_EOL.get_class($instance);
        if ( ! $this->canInitialize($instance))
        {
            return;
        }

//        echo ' yes ';

        if ($serviceLocator instanceof AbstractPluginManager)
        {
            $serviceLocator = $serviceLocator->getServiceLocator();
        }

        $instanceReflectionClass = new ReflectionClass( $instance );
        foreach ($instanceReflectionClass->getInterfaceNames() as $interfaceName) {

//            echo PHP_EOL.'   '.$interfaceName;
            if(!$this->canInitializeInterface($interfaceName)){
                continue;
            }
//            echo '   yes';

            $setters = $this->getSetterMethods($interfaceName);
            foreach($setters as $method){
                $parameterClasses = $method->getParameters();
//                echo PHP_EOL.'      '.$method->getName();
                foreach($parameterClasses as $parameter){
//                    echo ', '.$parameter->getName();
                    try {
                        $dependency = $this->getDependency($serviceLocator, $parameter->getClass());
//                        echo ' ('.get_class($dependency).') ';

                        // Set the dependency using the interface method.
                        $instance->{$method->getName()}($dependency);
                    } catch (Dependency $exception) {
                        throw new Dependency(
                            "Unable to inject interface [$interfaceName] into instance [{$instanceReflectionClass->getName()}], because {$exception->getMessage()}",
                            Dependency::ERROR_CODE,
                            $exception
                        );
                    }
                }
            }
        }
    }

    /**
     * @param $interfaceName
     * @return ReflectionMethod[]
     */
    protected function getSetterMethods($interfaceName)
    {
        $setters = array();
        $interfaceReflectionClass = new ReflectionClass( $interfaceName );
        $interfaceReflectionMethods = $interfaceReflectionClass->getMethods(ReflectionMethod::IS_PUBLIC);
        foreach($interfaceReflectionMethods as $method){
            $methodName = $method->getName();
            if(substr($methodName,0,3)==='set'){
                $setters[] = $method;
            }
        }
        return $setters;
    }

    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @param ReflectionClass $dependencyClass
     * @return mixed
     * @throws Dependency
     */
    private function getDependency(ServiceLocatorInterface $serviceLocator, ReflectionClass $dependencyClass)
    {
        // Load the dependency through the service locator.
        $className = $dependencyClass->getName();

        if ($serviceLocator->has($className)) {
            $dependency = $serviceLocator->get($className);
            return $dependency;
        }

        // if the class was not available throw the service locator then just try to get a regular instance.
        if(class_exists($className)){
            return new $className();
        }

        throw new Dependency( "'$className' is not a valid class" );
    }

    /**
     * @param InjectionHelper $injectionHelper
     * @return InterfaceInjection
     */
    public function setInjectionHelper($injectionHelper)
    {
        $this->injectionHelper = $injectionHelper;
        return $this;
    }

    /**
     * @return InjectionHelper
     */
    public function getInjectionHelper()
    {
        if(empty($this->injectionHelper)){
            $this->injectionHelper = new InjectionHelper();
        }
        return $this->injectionHelper;
    }


}