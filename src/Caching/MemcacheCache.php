<?php

namespace Kohana\Doctrine\Caching;

use Kohana\Doctrine\Exception\IncorrectConfigurationException;
use Memcache;

class MemcacheCache implements CacheInterface
{
    /**
     * @param array $cacheConfig
     * @return \Doctrine\Common\Cache\MemcacheCache
     * @throws IncorrectConfigurationException
     */
    public function configureCache(array $cacheConfig)
    {
        if (empty($cacheConfig['host'])) {
            throw new IncorrectConfigurationException('cache.memcache.host');
        }

        if (empty($cacheConfig['port'])) {
            throw new IncorrectConfigurationException('cache.memcache.port');
        }

        if (empty($cacheConfig['timeout'])) {
            $cacheConfig['timeout'] = 1;
        }

        $memcache = $this->configureMemcache($cacheConfig['host'], $cacheConfig['post'], $cacheConfig['timeout']);

        $cacheDriver = new \Doctrine\Common\Cache\MemcacheCache();
        $cacheDriver->setMemcache($memcache);

        return $cacheDriver;
    }

    /**
     * @param string $memcacheHost
     * @param int $memcachePort
     * @param int $memcacheTimeout
     * @return Memcache
     */
    private function configureMemcache($memcacheHost, $memcachePort, $memcacheTimeout)
    {
        $memcache = new Memcache;
        $memcache->connect($memcacheHost, $memcachePort, $memcacheTimeout);

        return $memcache;
    }
}
