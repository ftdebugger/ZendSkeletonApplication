<?php

return array(
    'assetic_configuration' => array(

        'modules' => array(
            /*
             * Application module - assets configuration
             */
            'admin' => array(

                # module root path for your css and js files
                'root_path' => __DIR__ . '/../assets',
                # collection od assets
                'collections' => array(

                    'admin_css' => array(
                        'assets' => array(
                            'css/style.css'
                        ),
                        'filters' => array(
                            'CssImportFilter' => array(
                                'name' => 'Assetic\Filter\CssImportFilter',
                            ),
                            'CssRewriteFilter' => array(
                                'name' => 'Assetic\Filter\CssRewriteFilter'
                            )
                        ),
                        'options' => array(
                            'output' => 'admin.css'
                        ),
                    ),
                    'admin_js' => array(
                        'assets' => array(
                            'js/jquery.min.js',
                            'js/bootstrap.min.js',
                        ),
                        'filters' => array(
                            '?UglifyJs2Filter' => array(
                                'name' => 'Assetic\Filter\UglifyJs2Filter',
                                'option' => array(
                                    'uglifyjsBin' => './node_modules/.bin/uglifyjs'
                                )
                            )
                        ),
                        'options' => array(
                            'output' => 'admin.js'
                        ),
                    ),
                    'base_images' => array(
                        'assets' => array(
                            'img/*.png',
                            'img/*.ico',
                        ),
                        'options' => array(
                            'move_raw' => true,
                        )
                    ),
                ),
            ),
        ),

        'routes' => array(
            'admin' => array(
                '@admin_js',
                '@admin_css',
            ),
            'admin/.*' => array(
                '@admin_js',
                '@admin_css',
            ),
        )
    )
);
