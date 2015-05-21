<?php

namespace Kohana\Doctrine;

use Doctrine\Common\Persistence\Mapping\Driver\MappingDriverChain;

/**
 * Class Configurator
 * @package Kohana\Doctrine
 */
class Configurator
{
    /**
     * @var Configuration
     */
    private $configuration;

    /**
     * @var Cache
     */
    private $cache;

    /**
     * @var Driver
     */
    private $mapping;
    /**
     * @var MappingDriverChain
     */
    private $driverChain;

    public function __construct()
    {
        $this->configuration = new Configuration;
        $this->cache = new Cache($this->configuration);
        $this->mapping = new Driver($this->configuration);
        $this->driverChain = new MappingDriverChain;
    }

    /**
     * Create a \Doctrine\ORM\Configuration based on the config given.
     * If no config are given the method will try to get the config from the configuration file.
     *
     * @return \Doctrine\ORM\Configuration
     */
    public function configureDoctrine()
    {
        $configuredCache = $this->cache->configureCache();
        $configuredMapping = $this->mapping->configureDriver($configuredCache);

        foreach ($this->configuration->get('namespaces') as $namespace => $path) {
            $this->driverChain->addDriver($configuredMapping->getMetadataDriverImpl(), $namespace);
        }

        $configuredMapping->setMetadataDriverImpl($this->driverChain);

        // Implement maximum caching
        $configuredMapping->setMetadataCacheImpl($configuredCache);
        $configuredMapping->setHydrationCacheImpl($configuredCache);
        $configuredMapping->setQueryCacheImpl($configuredCache);
        $configuredMapping->setResultCacheImpl($configuredCache);

        // Set proxies and proxie-prefix
        $configuredMapping->setProxyNamespace($this->configuration->get('proxy.namespace'));
        $configuredMapping->setAutoGenerateProxyClasses($this->configuration->get('proxy.generate'));

        return $configuredMapping;
    }
}
