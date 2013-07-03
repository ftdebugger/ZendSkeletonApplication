<?php

chdir(dirname(__DIR__));

// Setup auto load
$loader = require __DIR__ . "/../vendor/autoload.php";

// Run the application!
Zend\Mvc\Application::init(require __DIR__ . '/../config/application.config.php')->run();
