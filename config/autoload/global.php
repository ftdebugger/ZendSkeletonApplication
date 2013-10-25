<?php

return array(
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

    // fix for TwbBundle
    'view_helpers' => array(
        'invokables' => array(
            'formCollection' => 'Zend\Form\View\Helper\FormCollection',
            'form' => 'Zend\Form\View\Helper\Form',
        )
    ),
);
