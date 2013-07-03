<?php

namespace Admin;

return array(
    'service_manager' => array(
        'factories' => array(
            'admin-navigation' => 'Admin\Navigation\Service\AdminNavigationFactory',
            'admin-entities' => 'Admin\Entities\ContainerFactory'
        )
    ),
    'controllers' => array(
        'invokables' => array(
            'admin-index' => 'Admin\Controller\IndexController',
            'admin-entity' => 'Admin\Controller\EntityController',
        )
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            __NAMESPACE__ => __DIR__ . '/../view',
        ),
    ),
);
