<?php

namespace App;

use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Exception\MissingMappingDriverImplementation;
use Doctrine\ORM\ORMSetup;

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
        $config = ORMSetup::createAnnotationMetadataConfiguration(
            array(__DIR__.'/../src', __DIR__.'/../tests'),
            true
        );
        $connection = DriverManager::getConnection([
            'url' => 'mysql://root:valnet2021@localhost:3306/test',
            'driver' => 'pdo_mysql',
        ], $config);
        return new EntityManager($connection, $config);
    }
}