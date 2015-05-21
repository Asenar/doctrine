<?php

namespace Kohana\Doctrine;

use Kohana\Doctrine\Caching\CacheInterface;

/**
 * Class Cache
 * @package Kohana\Doctrine
 */
class Cache
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
     * @return \Doctrine\Common\Cache\CacheProvider
     */
    public function configureCache()
    {
        $cacheConfig = $this->configuration->get('cache');
        $cacheClassName = '\Kohana\Doctrine\Caching\\'. ucfirst($cacheConfig['type']) . 'Cache';

        /** @var CacheInterface $cacheClass */
        $cacheClass = new $cacheClassName();

        return $cacheClass->configureCache($cacheConfig);
    }
}
