<?php

namespace Kohana\Doctrine;

use Doctrine\ORM\Mapping\DefaultNamingStrategy;
use Doctrine\ORM\Mapping\UnderscoreNamingStrategy;
use Kohana\Doctrine\Driver\DriverInterface;
use Kohana\Doctrine\Exception\IncorrectConfigurationException;

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
     * @throws IncorrectConfigurationException
     */
    public function configureDriver(Cache $cache = null)
    {
        $mappingConfig = $this->configuration->get('mapping');
        $proxyConfig = $this->configuration->get('proxy');
        $onProduction = $this->configuration->get('onProduction');

        if (empty($mappingConfig['path'])) {
            throw new IncorrectConfigurationException('mapping.path');
        }

        if (empty($proxyConfig['path'])) {
            throw new IncorrectConfigurationException('proxy.path');
        }

        $namingStrategy = $this->getNamingStrategy($mappingConfig['namingStrategy']);

        $driverClassName = '\Kohana\Doctrine\Driver\\'. ucfirst($mappingConfig['type']) . 'Driver';

        /** @var DriverInterface $driverClass */
        $driverClass = new $driverClassName();
        $configuredDriver = $driverClass->configureDriver($mappingConfig, $proxyConfig, $onProduction, $cache);
        $configuredDriver->setNamingStrategy($namingStrategy);

        return $configuredDriver;
    }

    /**
     * @param array $namingStrategy
     * @return \Doctrine\ORM\Mapping\NamingStrategy
     * @throws IncorrectConfigurationException
     */
    private function getNamingStrategy(array $namingStrategy)
    {
        if (empty($namingStrategy['strategy'])) {
            throw new IncorrectConfigurationException('mapping.namingStrategy.strategy');
        }

        if ($namingStrategy['strategy'] === 'underscore') {
            return new UnderscoreNamingStrategy($namingStrategy['case']);
        }

        return new DefaultNamingStrategy;
    }
}
