<?php

namespace Kohana\Doctrine\Caching;

class ApcCache implements CacheInterface
{
    public function configureCache(array $cacheConfig)
    {
        return new \Doctrine\Common\Cache\ApcCache;
    }
}
