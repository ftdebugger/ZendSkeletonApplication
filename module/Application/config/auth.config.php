<?php

return array(
    'bjyauthorize' => array(
        'guards' => array(
            'BjyAuthorize\Guard\Route' => array(
                array('route' => 'home', 'roles' => ['guest'])
            ),
        )
    )
);
