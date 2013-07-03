<?php

namespace Admin;

use Admin\Service\EntityService;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\ServiceManager\ServiceManager;

/**
 * @author Evgeny Shpilevsky <evgeny@shpilevsky.com>
 */

class Module implements ConfigProviderInterface, ServiceProviderInterface
{

    /**
     * @return array|mixed|\Traversable
     */
    public function getConfig()
    {
        return array_merge(
            include __DIR__ . '/config/module.config.php',
            include __DIR__ . '/config/auth.config.php',
            include __DIR__ . '/config/navigation.config.php',
            include __DIR__ . '/config/route.config.php',
            include __DIR__ . '/config/assetic.config.php'
        );
    }

    /**
     * @return array
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
     * Expected to return \Zend\ServiceManager\Config object or array to
     * seed such an object.
     *
     * @return array|\Zend\ServiceManager\Config
     */
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'admin-config' => function (ServiceManager $sm) {
                    $config = $sm->get('Config');

                    return new Configuration($config['admin']);
                },
                'Admin/Service/EntityService' => function (ServiceManager $sm) {
                    return new EntityService($sm);
                }
            )
        );
    }

}
