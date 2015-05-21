<?php

namespace Kohana\Doctrine;

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

    public function __construct()
    {
        $this->configuration = new Configuration;
        $this->configurator = new Configurator;
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
