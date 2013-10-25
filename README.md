ZF2 + Doctrine + Twig + Assetic [![Build Status](https://travis-ci.org/ftdebugger/ZendSkeletonApplication.png?branch=master)](https://travis-ci.org/ftdebugger/ZendSkeletonApplication)
===============================

Based on [ZendSkeletonApplication](https://github.com/zendframework/ZendSkeletonApplication)


Installation Using Composer
---------------------------

The recommended way to get a working copy of this project is to clone the repository
and use `composer` to install dependencies using the `create-project` command:

    curl -s https://getcomposer.org/installer | php --
    php composer.phar create-project -sdev ftdebugger/zend-skeleton-application PATH_TO_INSTALL

Than copy `config/autoload/local.php.dist` to `config/autoload/local.php` and edit your DB settings.

    npm install
    ant build

Now your ZF application is ready