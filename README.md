ZendSkeletonApplication + Doctrine + Twig + Assetic
===================================================

Based on [ZendSkeletonApplication](https://github.com/zendframework/ZendSkeletonApplication)


Installation Using Composer
---------------------------

The recommended way to get a working copy of this project is to clone the repository
and use `composer` to install dependencies using the `create-project` command:

    curl -s https://getcomposer.org/installer | php --
    php composer.phar create-project -sdev ftdebugger/zend-skeleton-application PATH_TO_INSTALL

    npm install
    phing build

Than copy `config/autoload/local.php.dist` to `config/autoload/local.php` and edit your DB settings.

    phing doctrine-update