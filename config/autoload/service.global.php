<?php

return array(
    'service_manager' => array(
        'aliases' => array(
            'entity_manager' => 'Doctrine\ORM\EntityManager',
            'zfcuser_doctrine_em' => 'Doctrine\ORM\EntityManager',
        ),
        'factories' => array(
            'navigation' => 'Zend\Navigation\Service\DefaultNavigationFactory'
        ),
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
    ),
);