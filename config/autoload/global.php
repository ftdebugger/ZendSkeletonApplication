<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

return array(
    'service_manager' => array(
        'aliases' => array(
            'entity_manager' => 'Doctrine\ORM\EntityManager',
//            'doctrine.entitymanager.orm_default' => 'Doctrine\ORM\EntityManager'
            'zfcuser_doctrine_em' => 'Doctrine\ORM\EntityManager',
        ),
        'factories' => array(
            'navigation' => 'Zend\Navigation\Service\DefaultNavigationFactory'
        )
    ),
    'assetic_configuration' => array(
        'default' => array(
            'assets' => array(
                '@base_css',
                '@base_js',
            ),
            'options' => array(
                'mixin' => false
            ),
        ),

        'debug' => false,

        /*
         * Enable cache
         */
        'cacheEnabled' => true,

        /*
         * Cache dir
         */
        'cachePath' => __DIR__ . '/../../data/cache',

        /**
         * Module is not enabled if an MvcEvent::EVENT_DISPATCH_ERROR event occurs.
         * However, we may still want our assets for pages with dispatch errors.
         * So, we can build up a whitelist of errors for the module to be enabled for.
         */
        'acceptableErrors' => array(
            //defaults
            \Zend\Mvc\Application::ERROR_CONTROLLER_NOT_FOUND,
            \Zend\Mvc\Application::ERROR_CONTROLLER_INVALID,
            \Zend\Mvc\Application::ERROR_ROUTER_NO_MATCH,

            //allow assets when authorisation fails when using the BjyAuthorize module
            \BjyAuthorize\Guard\Route::ERROR,
        ),

        'webPath' => 'public/assets',
        'baseUrl' => '/assets'
    ),

    // Whether or not to enable a configuration cache.
    // If enabled, the merged configuration will be cached and used in
    // subsequent requests.
    'config_cache_enabled' => true,

    // The key used to create the configuration cache file name.
    'config_cache_key' => 'config',

    // Whether or not to enable a module class map cache.
    // If enabled, creates a module class map cache which will be used
    // by in future requests, to reduce the autoloading process.
    'module_map_cache_enabled' => true,

    // The key used to create the class map cache file name.
    'module_map_cache_key' => 'module-map',

    // The path in which to cache merged configuration.
    'cache_dir' => './data/cache',

    // Whether or not to enable modules dependency checking.
    // Enabled by default, prevents usage of modules that depend on other modules
    // that weren't loaded.
    'check_dependencies' => false,
);
