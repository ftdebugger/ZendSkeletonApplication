<?php

return array(
    'view_manager' => array(
        'display_not_found_reason' => false,
        'display_exceptions' => false,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),
);
