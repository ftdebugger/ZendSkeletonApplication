<?php

namespace Admin;

return array(
    'service_manager' => array(
        'factories' => array(
            'admin-navigation' => 'Admin\Navigation\Service\AdminNavigationFactory'
        )
    ),
    'controllers' => array(
        'invokables' => array(
            'admin-index' => 'Admin\Controller\IndexController'
        )
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            __NAMESPACE__ => __DIR__ . '/../view',
        ),
    ),
);