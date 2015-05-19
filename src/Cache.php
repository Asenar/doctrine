<?php

namespace Kohana\Doctrine;

use Kohana_Config;

/**
 * Class Cache
 * @package Kohana\Doctrine
 */
class Cache
{
    /**
     * @var Kohana_Config
     */
    private $kohanaConfig;

    public function __construct(Kohana_Config $kohanaConfig)
    {
        $this->kohanaConfig = $kohanaConfig;
    }

    /**
     * @param string $cacheName
     */
    public function configureCache($cacheName)
    {
        $cacheConfig = $this->kohanaConfig->load('doctrine')->get('cache');
        $cacheClass = '\Kohana\Doctrine\Caching\\'. ucfirst($cacheName) . 'Cache';

        return new $cacheClass($cacheConfig);
    }
}
