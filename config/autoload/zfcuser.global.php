<?php

return array(
    'zfcuser' => array(
        'enable_default_entities' => false,
        'user_entity_class' => 'User\Entity\User',
        'enable_display_name' => true,
        'enable_registration' => true,
        'enable_username' => true,
        'auth_identity_fields' => ['email', 'username']
    ),
);
