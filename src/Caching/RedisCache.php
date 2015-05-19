<?php

namespace Kohana\Doctrine\Caching;

use Exception;
use Kohana\Doctrine\Exception\IncorrectConfigurationException;
use Redis;

class RedisCache implements CacheInterface
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
            $cacheConfig['timeout'] = 0.0;
        }

        $redis = $this->configureRedis($cacheConfig['host'], $cacheConfig['port'], $cacheConfig['timeout']);

        $cacheDriver = new \Doctrine\Common\Cache\RedisCache;
        $cacheDriver->setRedis($redis);

        return $cacheDriver;
    }

    /**
     * @param string $redisHost
     * @param int $redisPort
     * @param float $redisTimeout
     * @return Redis
     * @throws Exception
     */
    private function configureRedis($redisHost, $redisPort, $redisTimeout)
    {
        if (!class_exists("Redis")) {
            throw new Exception("Redis cache is not available");
        }

        $redis = new Redis;
        $redis->connect($redisHost, $redisPort, $redisTimeout);

        return $redis;
    }
}
