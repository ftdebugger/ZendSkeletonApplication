<?php

return array(
    'doctrine' => array(
        'connection' => array(
            'orm_default' => array(
                'driverClass' => 'Doctrine\DBAL\Driver\PDOMySql\Driver',
                'params' => array(
                    'host' => 'localhost',
                    'port' => '3306',
                    'user' => '',
                    'password' => '',
                    'dbname' => '',
                    'charset' => 'utf8',
                    'driverOptions' => array(
                        1002 => 'SET NAMES utf8'
                    )
                ),
            )
        ),
        'configuration' => array(
            'orm_default' => array(
                'metadata_cache' => 'my_memcache',
                'query_cache' => 'my_memcache',
                'result_cache' => 'my_memcache',
            )
        ),
        // migrations configuration
        'migrations_configuration' => array(
            'orm_default' => array(
                'directory' => 'data/migrations',
                'namespace' => 'DoctrineORMModule\Migrations',
                'table' => 'migrations',
            ),
        ),
    )
);
