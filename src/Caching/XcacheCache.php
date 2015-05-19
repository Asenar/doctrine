<?php

namespace Kohana\Doctrine\Caching;

class XcacheCache implements CacheInterface
{
    public function configureCache(array $cacheConfig)
    {
        return new \Doctrine\Common\Cache\XcacheCache;
    }
}
