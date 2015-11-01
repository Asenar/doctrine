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

    /**
     * @param Configuration $configuration
     * @param Cache $cache
     * @param Driver $driver
     * @param MappingDriverChain $mappingDriverChain
     */
    public function __construct(
        Configuration $configuration,
        Cache $cache,
        Driver $driver,
        MappingDriverChain $mappingDriverChain
    ) {
        $this->configuration = $configuration;
        $this->cache = $cache;
        $this->mapping = $driver;
        $this->driverChain = $mappingDriverChain;
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
        $configuredDriver = $this->mapping->configureDriver($configuredCache);

        foreach ($this->configuration->get('namespaces') as $namespace => $path) {
            $this->driverChain->addDriver($configuredDriver->getMetadataDriverImpl(), $namespace);
        }

        $configuredDriver->setMetadataDriverImpl($this->driverChain);

        // Implement maximum caching
        $configuredDriver->setMetadataCacheImpl($configuredCache);
        $configuredDriver->setHydrationCacheImpl($configuredCache);
        $configuredDriver->setQueryCacheImpl($configuredCache);
        $configuredDriver->setResultCacheImpl($configuredCache);

        $proxyConfiguration = $this->configuration->get('proxy');

        // Set proxies and proxie-prefix
        $configuredDriver->setProxyNamespace($proxyConfiguration['namespace']);
        $configuredDriver->setAutoGenerateProxyClasses($proxyConfiguration['generate']);

        return $configuredDriver;
    }
}
