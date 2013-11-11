<?php

return array(
    'bjyauthorize' => array(
        'default_role' => 'guest',
        'identity_provider' => 'User\Provider\Identity',
        'unauthorized_strategy' => 'BjyAuthorize\View\RedirectionStrategy',

        /* role providers simply provide a list of roles that should be inserted
         * into the Zend\Acl instance. the module comes with two providers, one
         * to specify roles in a config file and one to load roles using a
         * Zend\Db adapter.
         */
        'role_providers' => array(
            'BjyAuthorize\Provider\Role\Config' => array(
                'guest' => array(),
                'user' => array(
                    'children' => array(
                        'manager' => array(
                            'children' => array(
                                'admin' => array()
                            )
                        ),
                    )
                )
            ),
        ),
        // resources providers provide a list of resources that will be tracked
        // in the ACL. like roles, they can be hierarchical
        'resource_providers' => array(
            'BjyAuthorize\Provider\Resource\Config' => array(
                'public' => array(),
                'not_logged' => array(),
                'logged' => array(),
                'learning' => array(),
                'protected' => array(),
                'admin' => array(),
            ),
        ),
        /* rules can be specified here with the format:
         * array(roles (array) , resources, [privilege (array|string), assertion])
         * assertions will be loaded using the service manager and must implement
         * Zend\Acl\Assertion\AssertionInterface.
         * *if you use assertions, define them using the service manager!*
         */
        'rule_providers' => array(
            'BjyAuthorize\Provider\Rule\Config' => array(
                'allow' => array(
                    array('guest', ['public', 'not_logged']),
                    array('user', ['public', 'logged']),
                    array('manager', 'protected'),
                    array('admin', 'admin'),
                ),
            ),
        ),
        /* Currently, only controller and route guards exist
         *
         * Consider enabling either the controller or the route guard depending on your needs.
         */
        'guards' => array( //'BjyAuthorize\Guard\Controller' => array(),
            'BjyAuthorize\Guard\Route' => array(
                array('route' => 'assetic-build', 'roles' => array('guest')),
            ),
        ),
    ),
);
