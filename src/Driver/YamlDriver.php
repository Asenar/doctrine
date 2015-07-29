<?php

namespace Kohana\Doctrine\Driver;

use Doctrine\Common\Cache\Cache;
use Doctrine\ORM\Tools\Setup;
use Kohana\Doctrine\Exception\IncorrectConfigurationException;

class YamlDriver implements DriverInterface
{
    /**
     * @param array $mappingConfig
     * @param array $proxyConfig
     * @param bool $onProduction
     * @param Cache $cache
     * @return \Doctrine\ORM\Configuration
     * @throws IncorrectConfigurationException
     */
    public function configureDriver(array $mappingConfig, array $proxyConfig, $onProduction = true, Cache $cache = null)
    {
        if (empty($mappingConfig['path'])) {
            throw new IncorrectConfigurationException('mapping.path');
        }

        if (empty($proxyConfig['path'])) {
            throw new IncorrectConfigurationException('proxy.path');
        }

        return Setup::createYAMLMetadataConfiguration(
            $mappingConfig['path'],
            $onProduction,
            $proxyConfig['path'],
            $cache
        );
    }
}
