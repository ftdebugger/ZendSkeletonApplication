<?php

return array(
    'caches' => array(
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

        'cache' => array(
            'adapter' => 'Zend\Cache\Storage\Adapter\Filesystem',
            'options' => array(
                'cache_dir' => 'data/cache',
                'namespace' => 'ZF2Application',
                'ttl' => 3600
            )
        ),
    ),
);