<?php

namespace Kohana\Doctrine\Driver;

use Doctrine\Common\Cache\Cache;

interface DriverInterface
{
    /**
     * @param array $mappingConfig
     * @param array $proxyConfig
     * @param bool $onProduction
     * @param Cache $cache
     * @return \Doctrine\ORM\Configuration
     */
    public function configureDriver(array $mappingConfig, array $proxyConfig, $onProduction = true, Cache $cache);
}
