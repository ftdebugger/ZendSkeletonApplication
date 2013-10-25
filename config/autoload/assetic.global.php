<?php

return array(
    'assetic_configuration' => array(
        'default' => array(
            'assets' => array(
                '@vendor_css',
                '@vendor_js',
            ),
            'options' => array(
                'mixin' => false
            ),
        ),
        'debug' => false,
        'cacheEnabled' => true,
        'cachePath' => __DIR__ . '/../../data/cache',
        'acceptableErrors' => array(
            //defaults
            \Zend\Mvc\Application::ERROR_CONTROLLER_NOT_FOUND,
            \Zend\Mvc\Application::ERROR_CONTROLLER_INVALID,
            \Zend\Mvc\Application::ERROR_ROUTER_NO_MATCH,
            \BjyAuthorize\Guard\Route::ERROR,
        ),
        'webPath' => 'public/assets',
        'baseUrl' => '/assets',
        'modules' => array(
            'global' => array(
                'root_path' => __DIR__ . '/../../vendor/bower',
                'collections' => array(
                    'vendor_css' => array(
                        'assets' => array(
                            'bootstrap/dist/css/bootstrap.min.css'
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
                            'output' => 'vendor.*.css'
                        ),
                    ),
                    'vendor_js' => array(
                        'assets' => array(
                            'jquery/jquery.min.js',
                            'bootstrap/dist/js/bootstrap.min.js',
                        ),
                        'filters' => array(
                            'EnliteUglifyFilter'
                        ),
                        'options' => array(
                            'output' => 'vendor.js'
                        ),
                    ),
                    'vendor_resource' => array(
                        'assets' => array(
                            'bootstrap/dist/fonts/*',
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
