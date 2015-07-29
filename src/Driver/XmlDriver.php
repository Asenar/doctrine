<?php

namespace Kohana\Doctrine\Driver;

use Doctrine\Common\Cache\Cache;
use Doctrine\ORM\Tools\Setup;
use Kohana\Doctrine\Exception\IncorrectConfigurationException;

class XmlDriver implements DriverInterface
{
    /**
     * @param array $mappingConfig
     * @param array $proxyConfig
     * @param bool $onProduction
     * @param Cache $cache
     * @return \Doctrine\ORM\Configuration
     */
    public function configureDriver(array $mappingConfig, array $proxyConfig, $onProduction = true, Cache $cache = null)
    {
        return Setup::createXMLMetadataConfiguration(
            $mappingConfig['path'],
            $onProduction,
            $proxyConfig['path'],
            $cache
        );
    }
}
