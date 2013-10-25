<?php

return array(
    'caches' => array(
//        // Redis cache
//        'cache' => array(
//            'adapter' => 'Zend\Cache\Storage\Adapter\Memcached',
//            'options' => array(
//                'servers' => array(
//                    'localhost:11211'
//                ),
//                'namespace' => 'ZF2Application',
//                'ttl' => 3600
//            )
//        ),

//        // Redis cache
//        'cache' => array(
//            'adapter' => 'Zend\Cache\Storage\Adapter\Redis',
//            'options' => array(
//                'namespace' => 'ZF2Application',
//                'server' => array(
//                    'host' => '127.0.0.1',
//                    'port' => 6379,
//                ),
//            ),
//            'plugins' => array(
//                'Zend\Cache\Storage\Plugin\ExceptionHandler',
//                'Zend\Cache\Storage\Plugin\Serializer'
//            )
//        ),

        'cache' => array(
            'adapter' => 'Zend\Cache\Storage\Adapter\Filesystem',
            'options' => array(
                'cache_dir' => 'data/cache',
                'namespace' => 'ZF2Application',
                'ttl' => 3600,
                'key_pattern' => '/.+/'
            ),
            'plugins' => array(
                'Application\Cache\Storage\Plugin\HashKey',
                'Zend\Cache\Storage\Plugin\ExceptionHandler',
                'Zend\Cache\Storage\Plugin\Serializer',
            )
        ),
    ),
);