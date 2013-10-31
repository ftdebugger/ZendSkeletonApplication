<?php

namespace Application;

use DoctrineModule\Cache\ZendStorageCache;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\ServiceManager\ServiceManager;

class Module implements ConfigProviderInterface, AutoloaderProviderInterface, ServiceProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }

    /**
     * {@inheritdoc}
     */
    public function getConfig()
    {
        $config = [];
        foreach (glob(__DIR__ . '/config/*.config.php') as $file) {
            $config = array_merge($config, include $file);
        }
        return $config;
    }

    /**
     * {@inheritdoc}
     */
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . "/autoload_classmap.php"
            ),
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'doctrine.cache.my_memcache' => function (ServiceManager $sm) {
                    return new ZendStorageCache($sm->get('cache'));
                },
            ),
        );
    }
}
