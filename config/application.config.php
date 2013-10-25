<?php

return array(
    'modules' => array(
        'ZendDeveloperTools',
        'DoctrineModule',
        'DoctrineORMModule',
        'TwbBundle',
        'ZfcTwig',
        'ZfcBase',
        'ZfcUser',
        'ZfcUser',
        'ZfcUserDoctrineORM',
        'AsseticBundle',
        'BjyAuthorize',
        'EnliteAdmin',
        'EnliteAssetic',
        //
        'Application',
        'User',
    ),
    'module_listener_options' => array(
        'module_paths' => array(
            './module',
            './vendor',
        ),
        'config_glob_paths' => array(
            'config/autoload/{,*.}global.php',
            'config/autoload/{,*.}local.php',
        ),
    ),
);
