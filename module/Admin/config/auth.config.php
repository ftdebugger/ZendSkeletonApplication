<?php

return array(
    'bjyauthorize' => array(
        'guards' => array(
            'BjyAuthorize\Guard\Route' => array(
                array('route' => 'admin', 'roles' => array('admin')),
            ),
        )
    )
);