<?php

return array(
    'assetic_configuration' => array(
        'default' => array(
            'assets' => array(
                '@app_css',
            ),
        ),
        'modules' => array(
            'application' => array(
                'root_path' => __DIR__ . '/../assets',
                'collections' => array(
                    'app_css' => array(
                        'assets' => array(
                            'css/index.css'
                        )
                    )
                ),
            ),
        )
    )
);
