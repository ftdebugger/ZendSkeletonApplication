<?php

return array(
    'bjyauthorize' => array(
        'guards' => array(
            'BjyAuthorize\Guard\Route' => array(
                array('route' => 'admin', 'roles' => array('admin')),
                array('route' => 'admin/entity', 'roles' => array('admin')),
                array('route' => 'admin/entity/entity', 'roles' => array('admin')),
                array('route' => 'admin/entity/entity/remove', 'roles' => array('admin')),
                array('route' => 'admin/entity/entity/create', 'roles' => array('admin')),
                array('route' => 'admin/entity/entity/edit', 'roles' => array('admin')),
            ),
        )
    )
);
