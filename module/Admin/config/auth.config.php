<?php

return array(
    'bjyauthorize' => array(
        'guards' => array(
            'BjyAuthorize\Guard\Route' => array(
                array('route' => 'admin', 'roles' => array('admin')),
                array('route' => 'admin/entities', 'roles' => array('admin')),
                array('route' => 'admin/entity', 'roles' => array('admin')),
                array('route' => 'admin/entity/remove', 'roles' => array('admin')),
                array('route' => 'admin/entity/create', 'roles' => array('admin')),
                array('route' => 'admin/entity/edit', 'roles' => array('admin')),
            ),
        )
    )
);
