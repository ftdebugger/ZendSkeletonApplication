<?php

return array(
    // fix for TwbBundle
    'view_helpers' => array(
        'invokables' => array(
            'formCollection' => 'Zend\Form\View\Helper\FormCollection',
            'form' => 'Zend\Form\View\Helper\Form',
        )
    ),
);
