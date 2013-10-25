<?php

return array(
    'view_manager' => array(
        'template_map' => array(
            'error/404' => __DIR__ . '/../view/error/404.twig',
            'error/index' => __DIR__ . '/../view/error/index.twig',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);
