<?php

/**
 * @author Evgeny Shpilevsky <evgeny@shpilevsky.com>
 */

namespace User;

use BjyAuthorize\Service\Authorize;
use User\Controller\Plugin\Authentication;
use Zend\EventManager\EventInterface;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ControllerPluginProviderInterface;
use Zend\Mvc\ApplicationInterface;
use Zend\Mvc\Controller\PluginManager;
use Zend\Mvc\MvcEvent;
use Zend\View\Helper\Navigation\AbstractHelper;

class Module implements
    ConfigProviderInterface,
    BootstrapListenerInterface,
    ControllerPluginProviderInterface,
    AutoloaderProviderInterface
{
    /**
     * {@inheritdoc}
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
