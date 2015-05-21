<?php

namespace Kohana\Doctrine\Caching;

class ApcCache implements CacheInterface
{
    /**
     * @param array $cacheConfig
     * @return \Doctrine\Common\Cache\CacheProvider
     */
    public function configureCache(array $cacheConfig)
    {
        return new \Doctrine\Common\Cache\ApcCache;
    }
}
