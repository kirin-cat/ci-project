<?php

error_reporting(E_ALL);

require __DIR__ . '/vendor/autoload.php';

use Doctrine\ORM\Tools\Console\ConsoleRunner;

define('ENVIRONMENT', isset($_SERVER['CI_ENV']) ? $_SERVER['CI_ENV'] : 'development');
define('BASEPATH', __DIR__ . '/vendor/codeigniter/framework/system/');
define('APPPATH', __DIR__ . '/application/');

require APPPATH . 'libraries/Doctrine.php';
$doctrine = new Doctrine();
return ConsoleRunner::createHelperSet($doctrine->em);
