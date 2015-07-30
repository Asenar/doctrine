<?php

namespace Kohana\Doctrine;

use Doctrine\Common\Persistence\Mapping\Driver\MappingDriverChain;
use Doctrine\ORM\EntityManager as DoctrineEntityManager;
use Kohana;

/**
 * Provide access to a Doctrine2 EntityManager
 */
class EntityManager
{
    /**
     * @static DoctrineEntityManager This attribute will be set if the EntityManager is created
     */
    private static $entityManagerInstance = null;

    /**
     * @var Configuration
     */
    private $configuration;

    /**
     * @var Configurator
     */
    private $configurator;

    /**
     * @var EventManager
     */
    private $eventManager;

    public function __construct()
    {
        $configuration = new Configuration;
        $cache = new Cache($configuration);
        $mapping = new Driver($configuration);
        $driverChain = new MappingDriverChain;

        $this->configuration = $configuration;
        $this->configurator = new Configurator($configuration, $cache, $mapping, $driverChain);
        $this->eventManager = new EventManager;
    }

    /**
     * @return EntityManager
     */
    public static function instance()
    {
        if (is_null(self::$entityManagerInstance)) {
             $entityManager = new self;

            self::$entityManagerInstance = $entityManager->create();
        }

        return self::$entityManagerInstance;
    }

    /**
     * Get an instance of the \Doctrine\ORM\EntityManager
     *
     * The EntityManager is build based on the database.php config file
     *
     * @return \Doctrine\ORM\EntityManager
     */
    public function create()
    {
        return DoctrineEntityManager::create(
            $this->configuration->get('credentials'),
            $this->configurator->configureDoctrine(),
            $this->eventManager->configureEventManager()
        );
    }
}
