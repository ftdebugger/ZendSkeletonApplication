<?php

namespace User;

use User\Controller\Plugin\Authentication;
use BjyAuthorize\Service\Authorize;
use User\Provider\Identity;
use User\Service\UserService;
use Zend\EventManager\EventInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ControllerPluginProviderInterface;
use Zend\Mvc\ApplicationInterface;
use Zend\Mvc\Controller\PluginManager;
use Zend\Mvc\MvcEvent;
use Zend\ServiceManager\ServiceManager;
use Zend\View\Helper\Navigation\AbstractHelper;

/**
 * @author Evgeny Shpilevsky <evgeny@shpilevsky.com>
 */

class Module implements ConfigProviderInterface, BootstrapListenerInterface, ControllerPluginProviderInterface
{
    /**
     * Listen to the bootstrap event
     *
     * @param  EventInterface $e
     * @return array
     */
    public function onBootstrap(EventInterface $e)
    {
        /** @var ApplicationInterface $app */
        $app = $e->getTarget();

        $serviceManager = $app->getServiceManager();
        $app->getEventManager()->attach(
            [MvcEvent::EVENT_DISPATCH, MvcEvent::EVENT_DISPATCH_ERROR],
            function () use ($serviceManager) {
                /** @var Authorize $auth */
                $auth = $serviceManager->get('BjyAuthorize\Service\Authorize');

                AbstractHelper::setDefaultAcl($auth->getAcl());
                AbstractHelper::setDefaultRole($auth->getIdentity());
            }
        );
    }

    /**
     * @return array|mixed|\Traversable
     */
    public function getConfig()
    {
        return array_merge(
            include __DIR__ . '/config/module.config.php',
            include __DIR__ . '/config/auth.config.php'
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
     * @return array
     */
    public function getServiceConfig()
    {
        return array(
            'aliases' => array(
                'zfcuser_doctrine_em' => 'doctrine.entitymanager.orm_default',

            ),
            'factories' => array(
                'User\Provider\Identity' => function (ServiceManager $sm) {
                    return new Identity($sm->get('UserService'));
                },
                'UserService' => function (ServiceManager $sm) {
                    return new UserService($sm);
                },
            ),
        );
    }

    /**
     * Expected to return \Zend\ServiceManager\Config object or array to
     * seed such an object.
     *
     * @return array|\Zend\ServiceManager\Config
     */
    public function getControllerPluginConfig()
    {
        return array(
            'factories' => array(
                'authentication' => function (PluginManager $sm) {
                    return new Authentication($sm->getServiceLocator());
                }
            )
        );
    }

}
