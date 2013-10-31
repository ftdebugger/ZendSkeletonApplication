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

    ant up

Now your ZF application is ready

Developing with Vagrant
-----------------------

Install [Vagrant](http://www.vagrantup.com/) ant [VirtualBox](https://www.virtualbox.org/) on your computer.
For Ubuntu or Mint you can do it like this

```bash
sudo apt-get install vagrant virtualbox
```

If you want, you can install newer version of VirtualBox from [official site](https://www.virtualbox.org/wiki/Linux_Downloads)

Next step, install dependencies from git submodules (you must have initiated git repository for this step)

```
git submodule update
```

Now we are ready for a little magic

```
sudo sh -c 'echo "192.168.56.101 zf2application.dev www.zf2application.dev" >> /etc/hosts'

cd vagrant
vagrant up
vagrant ssh
cd /var/www/zf2application

ant up
```

Open you browser [http://zf2application.dev/](http://zf2application.dev/)