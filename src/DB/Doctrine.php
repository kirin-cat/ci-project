<?php

namespace Kirin\CI\DB;

use Doctrine\Common\ClassLoader;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

class Doctrine
{
    public $em = null;

    public function __construct($isDev = false)
    {
        // Load the database configuration from CodeIgniter
        require APPPATH . 'config/database.php';
        $configs = array(
            'driver'		=> 'pdo_mysql',
            'user'			=> $db['default']['username'],
            'password'		=> $db['default']['password'],
            'host'			=> $db['default']['hostname'],
            'dbname'		=> $db['default']['database'],
            'charset'		=> $db['default']['char_set'],
            'driverOptions'	=> array(
                'charset'	=> $db['default']['char_set'],
            ),
        );
        // With this configuration, your model files need to be in application/models/Entity
        // e.g. Creating a new Entity\User loads the class from application/models/Entity/User.php
        $modelsNamespace = 'Entity';
        $modelsPath = APPPATH . 'models';
        $proxiesDir = APPPATH . 'models/Proxies';
        $metadataPaths = array(APPPATH . 'models/Entity');

        // If you want to use a different metadata driver, change createAnnotationMetadataConfiguration
        // to createXMLMetadataConfiguration or createYAMLMetadataConfiguration.
        $config = Setup::createAnnotationMetadataConfiguration($metadataPaths, $isDev, $proxiesDir);
        $this->em = EntityManager::create($configs, $config);
        $loader = new ClassLoader($modelsNamespace, $modelsPath);
        $loader->register();
    }
}
