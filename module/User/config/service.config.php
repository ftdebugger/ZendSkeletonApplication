<?php

return array(
    'service_manager' => array(
        'invokables' => array(
        ),
        'factories' => array(
            'UserService' => 'User\Service\UserServiceFactory',
            'User\Provider\Identity' => 'User\Provider\IdentityFactory'
        ),
        'aliases' => array(
            'zfcuser_doctrine_em' => 'doctrine.entitymanager.orm_default',
        ),
    )
);