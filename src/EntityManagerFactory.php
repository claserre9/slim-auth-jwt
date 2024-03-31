<?php

namespace App;

use Doctrine\Common\EventManager;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Tools\DsnParser;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Exception\MissingMappingDriverImplementation;
use Doctrine\ORM\ORMSetup;

/**
 * Class EntityManagerFactory
 *
 * The EntityManagerFactory class is responsible for creating a new instance of the EntityManager.
 */
class EntityManagerFactory
{

	/**
	 * Creates a new instance of the EntityManager.
	 *
	 * @return EntityManager The created EntityManager instance.
	 *
	 * @throws Exception
	 * @throws MissingMappingDriverImplementation
	 */
    public static function create(): EntityManager
    {
        $config = ORMSetup::createAttributeMetadataConfiguration(
            array(__DIR__.'/../src', __DIR__.'/../tests'),
            true
        );

//	    $config->setProxyDir(__DIR__ . '/../cache/proxies');
//	    $config->setProxyNamespace('Proxies');
//	    $config->setAutoGenerateProxyClasses(true);


	    $dsnParser = new DsnParser();
	    $connectionParams = $dsnParser
		    ->parse('mysqli://root@localhost:3306/slim-jwt-db');

	    $connection = DriverManager::getConnection($connectionParams, $config);

		$eventManager = new EventManager();

        return new EntityManager($connection, $config, $eventManager);
    }
}
