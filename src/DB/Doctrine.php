<?php

use Doctrine\Common\ClassLoader;
use Doctrine\ORM\EntityManager;
use Doctrine\Common\EventManager;
use Doctrine\ORM\Configuration;
use Doctrine\Common\Annotations\CachedReader;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Cache\ArrayCache;
use Doctrine\Common\Persistence\Mapping\Driver\MappingDriverChain;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\Common\Annotations\AnnotationRegistry;

class Doctrine
{
    public $em = null;

    public function __construct($isDev = false)
    {
        // Load the database configuration from CodeIgniter
        require APPPATH . 'config/database.php';
        $configs = array(
            'driver' => 'pdo_mysql',
            'user' => $db['default']['username'],
            'password' => $db['default']['password'],
            'host' => $db['default']['hostname'],
            'dbname' => $db['default']['database'],
            'charset' => $db['default']['char_set'],
            'driverOptions' => array(
                'charset' => $db['default']['char_set'],
            ),
        );

        $entitiesClassLoader = new ClassLoader('models', rtrim(APPPATH, "/" ));
        $entitiesClassLoader->register();

        AnnotationRegistry::registerFile(
            APPPATH . '/../vendor/doctrine/orm/lib/Doctrine/ORM/Mapping/Driver/DoctrineAnnotations.php'
        );

        $cache = new ArrayCache();
        $annotationReader = new AnnotationReader();
        $cachedAnnotationReader = new CachedReader(
            $annotationReader, // use reader
            $cache // and a cache driver
        );

        $driverChain = new MappingDriverChain();
        Gedmo\DoctrineExtensions::registerAbstractMappingIntoDriverChainORM(
            $driverChain, // our metadata driver chain, to hook into
            $cachedAnnotationReader // our cached annotation reader
        );

        $annotationDriver = new AnnotationDriver(
            $cachedAnnotationReader, // our cached annotation reader
            array(APPPATH . '/models/Entity') // paths to look in
        );

        $driverChain->addDriver($annotationDriver, 'CI\Entity');

        // general ORM configuration
        $config = new Configuration;
        $config->setProxyDir(sys_get_temp_dir());
        $config->setProxyNamespace('Proxy');
        $config->setAutoGenerateProxyClasses(ENVIRONMENT == "development");
        $config->setMetadataDriverImpl($driverChain);
        $config->setMetadataCacheImpl($cache);
        $config->setQueryCacheImpl($cache);


        $evm = new EventManager;

        // timestampable
        $timestampableListener = new Gedmo\Timestampable\TimestampableListener();
        $timestampableListener->setAnnotationReader($cachedAnnotationReader);
        $evm->addEventSubscriber($timestampableListener);

        // Set up logger
        //$logger = new EchoSQLLogger();
        //$config->setSQLLogger($logger);

        $this->em = EntityManager::create($configs, $config, $evm);
    }
}
