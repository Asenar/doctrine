<?php

namespace Kohana\Doctrine;

use Doctrine\Common\Cache\Cache;
use Kohana\Doctrine\Driver\DriverInterface;

/**
 * Class Driver
 * @package Kohana\Doctrine
 */
class Driver
{
    /**
     * @var Configuration
     */
    private $configuration;

    /**
     * @param Configuration $configuration
     */
    public function __construct(Configuration $configuration)
    {
        $this->configuration = $configuration;
    }

    /**
     * @param Cache $cache
     * @return \Doctrine\ORM\Configuration
     */
    public function configureDriver(Cache $cache)
    {
        $mappingConfig = $this->configuration->get('mapping');
        $proxyConfig = $this->configuration->get('proxy');
        $onProduction = $this->configuration->get('onProduction');

        $driverClassName = '\Kohana\Doctrine\Driver\\'. ucfirst($mappingConfig['type']) . 'Driver';

        /** @var DriverInterface $driverClass */
        $driverClass = new $driverClassName();

        return $driverClass->configureDriver($mappingConfig, $proxyConfig, $onProduction, $cache);
    }
}
