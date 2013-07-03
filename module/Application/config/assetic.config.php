<?php

return array(
    'assetic_configuration' => array(

        'modules' => array(
            /*
             * Application module - assets configuration
             */
            'application' => array(

                # module root path for your css and js files
                'root_path' => __DIR__ . '/../assets',
                # collection od assets
                'collections' => array(

                    'base_css' => array(
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
                            'output' => 'base.css'
                        ),
                    ),
                    'base_js' => array(
                        'assets' => array(
                            'js/jquery.min.js',
                            'js/bootstrap.min.js',
                            'js/html5.js',
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
                            'output' => 'base.js'
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
        )
    )
);
